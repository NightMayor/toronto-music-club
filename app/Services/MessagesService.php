<?php namespace App\Services;

use DB;
use Cache;
use Exception;

use App\User;
use App\Thread;
use App\Message;
use App\UsersThread;
use App\UsersMessage;

class MessagesService {

	public static function createMessage($thread_id, $user_id, $recipients = [], $body = '')
	{
		// get user info
		$user = User::find($user_id);
		
		// if the user does not exist
		if (!$user) {
			throw new Exception('User does not exist');
		}

		// get thread info
		$thread = Thread::find($thread_id);
		
		// if the thread does not exist
		if (!$thread) {
			throw new Exception('Conversation does not exist');
		}

		// get authors connection to conversation
		$users_thread = UsersThread::where('user_id', $user_id)
			->where('thread_id', $thread_id)
			->first();

		// make sure author belongs in this conversation
		if (!$users_thread) {
			throw new Exception('This conversation is not yours to participate in');
		}

		// make sure conversation is active
		if ($users_thread->active == 0) {
			try {
				// update authors conversation
				$users_thread->active = 1;
				$users_thread->save();
			} catch (Exception $e) {
				throw new Exception('Could not reactivate conversation for author');
			}
		}

		// make sure there are recipients
		if (count($recipients) < 1) {
			throw new Exception('A message must have a recipient');
		}

		// make sure the message has a body
		if (strlen($body) < 1) {
			throw new Exception('The body of your message may not be blank');
		}

		try {
			// create message
			$message            = new Message();
			$message->user_id   = $user_id;
			$message->thread_id = $thread_id;
			$message->body      = $body;
			$message->save();
		} catch (Exception $e) {
			throw new Exception('Could not create message');
		}

		try {
			// create record of author in users_messages
			$author_message               = new UsersMessage();
			$author_message->user_id      = $user_id;
			$author_message->message_id   = $message->id;
			$author_message->message_read = 1;
			$author_message->save();
		} catch (Exception $e) {
			throw new Exception('Could not create authors connection to message');
		}

		// forget authors thread cache
		Cache::forget('users_thread_' . $users_thread->id);

		// loop through all the recipients and...
		foreach ($recipients as $recipient) {
			// after making sure the recipient is not the author
			if ($recipient != $user_id) {
				// get recipients connection to conversation
				$users_thread = UsersThread::where('user_id', $recipient)
					->where('thread_id', $thread_id)
					->first();

				// make sure recipient belongs in this conversation
				if (!$users_thread) {
					throw new Exception('Recipient is not involved in this conversation');
				}

				// make sure conversation is active
				if ($users_thread->active == 0) {
					try {
						// update recipients conversation
						$users_thread->active = 1;
						$users_thread->save();
					} catch (Exception $e) {
						throw new Exception('Could not reactivate conversation for recipient');
					}
				}
				
				try {
					// create record of recipient in users_messages
					$recipient_message             = new UsersMessage();
					$recipient_message->user_id    = $recipient;
					$recipient_message->message_id = $message->id;
					$recipient_message->save();
				} catch (Exception $e) {
					throw new Exception('Could not create recipients connection to message');
				}

				// forget the recipients thread cache
				Cache::forget('users_thread_' . $users_thread->id);	
			}
		}
	}
}
