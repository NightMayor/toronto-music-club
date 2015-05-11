<?php namespace App\Services;

use DB;
use Cache;
use Input;
use App\User;
use Exception;
use App\Instrument;
use App\AvailablePost;
use App\UsersInstrument;
use App\Services\SubscriptionsService;

class AvailablePostsService {

	public static function getAllAvailablePosts()
	{
		return true;
	}

	public static function getAvailablePostsByUserId($user_id)
	{	
		// get user info
		$user = User::find($user_id);
		
		// if the user does not exist
		if (!$user) {
			throw new Exception('User does not exist');
		}

		return true;
	}

	public static function createAvailablePost($user_id)
	{	
		// get user info
		$user = User::find($user_id);
		
		// if the user does not exist
		if (!$user) {
			throw new Exception('User does not exist');
		}

		// make sure instrument has been sent and is numeric
		if (!is_numeric(Input::get('instrument'))) {
			throw new Exception('Instrument is a required field');
		}

		// get all the users active available posts
		$active_posts = AvailablePost::where('user_id', $user_id)
			->get();

		// get users subscription info
		$subscription = SubscriptionsService::getSubscriptionByUserId($user_id);

		// make sure user has not used up their limit of available posts
		if (count($active_posts) >= $subscription[0]->available_posts) {
			throw new Exception($subscription[0]->description . ' accounts may not have more than ' . $subscription[0]->available_posts . ' concurrent Available Posts');			
		}

		// make sure instrument is a valid selection
		$instrument = Instrument::find(Input::get('instrument'));

		// if instrument does not exist
		if (!$instrument) {
			throw new Exception('That is not one of the options for Instrument');
		}

		// get record of user having this instrument set as either primary or secondary
		$available_instrument = UsersInstrument::where('user_id', $user_id)
			->where('instrument_id', $instrument->id)
			->first();
		
		// make sure instrument is one of users instruments
		if (!$available_instrument) {
			throw new Exception('Instrument selected must be one of your Primary or Secondary Instruments');
		}

		// make sure the title of the post was sent
		if (!Input::has('title')) {
			throw new Exception('Your Available Post must have a title');
		}

		// set title from input
		$title = Input::get('title');

		// make sure title is not greater than 500 characters
		if (strlen($title) > 50) {
			throw new Exception('Please limit your Available Post title to 50 characters');		
		}

		// make sure the body of the post was sent
		if (!Input::has('body')) {
			throw new Exception('Your Available Post must have a description');
		}

		// set body from input
		$body = Input::get('body');

		// make sure body is not greater than 500 characters
		if (strlen($body) > 500) {
			throw new Exception('Please limit your Available Post description to 500 characters');		
		}
		
		try {
			// create new available post
			$new_post                = new AvailablePost;
			$new_post->user_id       = $user_id;
			$new_post->instrument_id = $instrument->id;
			$new_post->title         = $title;
			$new_post->body          = $body;
			$new_post->save();
		} catch (Exception $e) {
			throw new Exception('Could not create Available Post');
		}

		// forget the all available posts cache
		Cache::forget('available_posts_0');

		// forget the cache for this instruments available posts cache
		Cache::forget('available_posts_' . $instrument->id);

		// forget this users available posts
		Cache::forget('users_available_posts_' . $user_id);
	}
}
