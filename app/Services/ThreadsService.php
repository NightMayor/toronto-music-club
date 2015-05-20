<?php namespace App\Services;

use DB;
use Auth;
use Input;
use Cache;
use Exception;

use App\User;
use App\Thread;
use App\UsersThread;
use App\UsersMessage;
use App\Services\MessagesService;

class ThreadsService {

	public static function getThreadsByUserId($user_id)
	{
		// initialize threads array
		$threads = [
			'inbox' => [],
			'trash' => [],
		];

		// get all threads user belongs to
		$users_threads = UsersThread::where('user_id', $user_id)->get();

		// loop through all of the users threads
		foreach ($users_threads as $users_thread) {
			// get thread info
			$thread_info = ThreadsService::getThreadInfoByUsersThreadId($users_thread->id);
			
			// either store the thread in users inbox or trash
			switch ($users_thread->active) {
				case 1:
					$threads['inbox'][] = $thread_info;
					break;
				
				default:
					$threads['trash'][] = $thread_info;
					break;
			}
		}

		return $threads;
	}

	public static function getThreadInfoByUsersThreadId($users_thread_id)
	{
		// if cache does not exist
		if (!Cache::has('users_thread_' . $users_thread_id)) {
			
			// get users thread
			$users_thread = UsersThread::find($users_thread_id);

			// make sure users thread can be found
			if (!$users_thread) {
				throw new Exception('Link to conversation could not be found');
			}

			// make sure this is the logged in users conversation
			if (Auth::id() != $users_thread->user_id) {
				throw new Exception('This is not your conversation');
			}

			// get thread
			$thread = Thread::find($users_thread->thread_id);

			// make sure this thread exists
			if (!$thread) {
				throw new Exception('Conversation does not exist');
			}

			// get all messages that belong to this thread
			$users_messages = DB::table('messages')
				->join('users_messages', 'messages.id', '=', 'users_messages.message_id')
				->join('users', 'messages.user_id', '=', 'users.id')
				->select('messages.*', 'users.name', 'users_messages.message_read')
				->where('users_messages.user_id', $users_thread->user_id)
				->where('messages.thread_id', $thread->id)
				->whereNull('messages.deleted_at')
				->whereNull('users_messages.deleted_at')
				->get();

			$new_message = 0;

			foreach ($users_messages as $users_message) {
				// see if there are any unread messages
				if ($users_message->message_read == 0) {
					$new_message = 1;
				}
			}

			// get a list of all participants (who aren't the logged in user)
			$other_participants = DB::table('users_threads')
				->join('users', 'users_threads.user_id', '=', 'users.id')
				->select('users_threads.user_id','users.name')
				->where('users_threads.thread_id', $thread->id)
				->where('users.id', '!=', $users_thread->user_id)
				->whereNull('users_threads.deleted_at')
				->get();

			// create array of all the treads info
			$thread_info = [
				'users_thread_id'    => $users_thread_id,
				'active'             => $users_thread->active,
				'subject'            => $thread->subject,
				'thread_began'       => $thread->created_at->toDateTimeString(),
				'new_message'        => $new_message,
				'other_participants' => $other_participants,
				'messages'           => $users_messages,
			];
			

			// cache all the threads info
			Cache::put('users_thread_' . $users_thread_id, $thread_info, 10080);
		}

		// return info from cache
		return Cache::get('users_thread_' . $users_thread_id);
	}

	public static function createThread($user_id)
	{
		// make sure subject of the thread was sent
		if (!Input::has('subject')) {
			throw new Exception('Your message must have a subject');
		}

		// set subject from input
		$subject = Input::get('subject');

		// make sure subject is not greater than 100 characters
		if (strlen($subject) > 100) {
			throw new Exception('Please limit the subject of your message to 100 characters');		
		}

		// make sure recipients of the thread were sent
		if(!is_array(Input::get('recipient'))) {
			throw new Exception('There must be a recipient of your message');
		}

		// set recipients from input
		$recipients = Input::get('recipient');

		// loop through all the recipients and...
		foreach ($recipients as $recipient) {
			// make sure every recipient is numeric
			if (!is_numeric($recipient)) {
				throw new Exception('Invalid recipient');
			}
		}

		// make sure message body was sent
		if (!Input::has('body')) {
			throw new Exception('The body of your message may not be blank');
		}

		// set body from input
		$body = Input::get('body');

		// make sure body is not greater than 1024 characters
		if (strlen($body) > 1024) {
			throw new Exception('Please limit the body of your message to 1024 characters (it currently has ' . strlen($body) . ')');		
		}

		// create a transaction to wrap the creation of Thread, UsersThread, Message, and UsersMessage
		DB::transaction(function() use ($user_id, $subject, $recipients, $body)
		{
			try {
				// create new thread
				$thread          = new Thread();
				$thread->subject = $subject;
				$thread->save();
			} catch (Exception $e) {
				throw new Exception('Could not create conversation');
			}

			try {
				// create record of author in users_threads
				$author_thread            = new UsersThread();
				$author_thread->user_id   = $user_id;
				$author_thread->thread_id = $thread->id;
				$author_thread->save();
			} catch (Exception $e) {
				throw new Exception('Could not create authors connection to conversation');
			}

			// loop through all the recipients and...
			foreach ($recipients as $recipient) {

				// make sure the recipient is not the author
				if ($recipient != $user_id) {
					try {
						// create record of recipient in users_threads
						$recipient_thread            = new UsersThread();
						$recipient_thread->user_id   = $recipient;
						$recipient_thread->thread_id = $thread->id;
						$recipient_thread->save();
					} catch (Exception $e) {
						throw new Exception('Could not create recipients connection to conversation');
					}
				}
			}

			// create message (users threads caches are deleted in createMessage)
			MessagesService::createMessage($thread->id, $user_id, $recipients, $body);			
		});
	}

	public static function replyMessage($user_id, $thread_id)
	{
		// make sure message body was sent
		if (!Input::has('body')) {
			throw new Exception('The body of your message may not be blank');
		}

		// set body from input
		$body = Input::get('body');

		// make sure body is not greater than 1024 characters
		if (strlen($body) > 1024) {
			throw new Exception('Please limit the body of your message to 1024 characters (it currently has ' . strlen($body) . ')');		
		}

		// get list of recipients
		$recipients = UsersThread::where('thread_id', $thread_id)
			->lists('user_id');

		// create a transaction to wrap the creation of Message, and UsersMessage
		DB::transaction(function() use ($user_id, $thread_id, $recipients, $body)
		{
			// make sure any messages in this thread are marked as read by the author 
			$unread_messages = DB::table('messages')
				->join('users_messages', 'messages.id', '=', 'users_messages.message_id')
				->select('users_messages.id as users_message_id')
				->where('users_messages.user_id', $user_id)
				->where('users_messages.message_read', 0)
				->where('messages.thread_id', $thread_id)
				->lists('users_message_id');

			// loop through any found to not be read
			foreach ($unread_messages as $unread_message) {
				// get record of users message
				$users_message = UsersMessage::find($unread_message);
				
				// mark users message as read
				$users_message->message_read = 1;
				$users_message->save();
			}

			// create message (users threads caches are deleted in createMessage)
			MessagesService::createMessage($thread_id, $user_id, $recipients, $body);					
		});
	}

	public static function deleteUsersThreadById($users_thread_id)
	{
		// make sure thread id is numeric
		if (!is_numeric($users_thread_id)) {
			throw new Exception('Invalid conversation');
		}

		// get this users thread
		$users_thread = UsersThread::find($users_thread_id);

		// make sure the thread exists (could be found)
		if (!$users_thread) {
			throw new Exception('Could not find conversation (perhaps it has already been deleted)');
		}

		// make sure this UsersThread belongs to logged in user
		if (Auth::id() != $users_thread->user_id) {
			throw new Exception('This conversation is not yours to delete');
		}

		// mark UsersThread as inactive
		try {
			$users_thread->active = 0;
			$users_thread->save();
		} catch (Exception $e) {
			throw new Exception('Could not delete conversation');
		}
		
		// forget cache of users threads
		Cache::forget('users_thread_' . $users_thread->id);
	}
}
