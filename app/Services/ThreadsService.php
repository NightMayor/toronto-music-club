<?php namespace App\Services;

use DB;
use Input;
use Exception;

use App\User;
use App\Thread;
use App\UsersThread;
use App\Services\MessagesService;

class ThreadsService {

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

			// create message
			MessagesService::createMessage($thread->id, $user_id, $recipients, $body);			
		});

		// dd(Input::get('recipient'));
	}
}
