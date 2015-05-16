<?php namespace App\Services;

use DB;
use Input;
use Cache;
use Exception;

use App\User;
use App\Thread;
use App\UsersThread;
use App\Services\MessagesService;

class ThreadsService {

	public static function getThreadsByUserId($user_id)
	{
		// if cache does not exist
		if (!Cache::has('threads_' . $user_id)) {

			// initialize threads array
			$threads = [
				'inbox' => [],
				'trash' => [],
			];

			// get all threads user belongs to
			$users_threads = DB::table('threads')
				->join('users_threads', 'threads.id', '=', 'users_threads.thread_id')
				->select('threads.*', 'users_threads.active')
				->where('users_threads.user_id', $user_id)
				->whereNull('threads.deleted_at')
				->whereNull('users_threads.deleted_at')
				->get();

			// loop through all of the users threads
			foreach ($users_threads as $users_thread) {
				// get all messages that belong to this thread in 
				$users_messages = DB::table('messages')
					->join('users_messages', 'messages.id', '=', 'users_messages.message_id')
					->join('users', 'messages.user_id', '=', 'users.id')
					->select('messages.*', 'users.name', 'users_messages.message_read')
					->where('users_messages.user_id', $user_id)
					->where('messages.thread_id', $users_thread->id)
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
					->where('users_threads.thread_id', $users_thread->id)
					->where('users.id', '!=', $user_id)
					->whereNull('users_threads.deleted_at')
					->get();

				// create array of all the treads info
				$thread_info = [
					'active'             => $users_thread->active,
					'subject'            => $users_thread->subject,
					'thread_began'       => $users_thread->created_at,
					'other_participants' => $other_participants,
					'new_message'        => $new_message,
					'messages'           => $users_messages,
				];
				
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

			// cache all the threads info
			Cache::put('threads_' . $user_id, $threads);
		}

		// return info from cache
		return Cache::get('threads_' . $user_id);
	}

	public static function createThread($user_id)
	{
		// get user info
		$user = User::find($user_id);
		
		// if the user does not exist
		if (!$user) {
			throw new Exception('User does not exist');
		}

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

			// create message (users threads caches are deleted in createMessage)
			MessagesService::createMessage($thread->id, $user_id, $recipients, $body);			
		});
	}
}
