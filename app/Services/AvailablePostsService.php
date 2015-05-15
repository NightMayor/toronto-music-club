<?php namespace App\Services;

use DB;
use Auth;
use Cache;
use Input;
use Exception;

use App\User;
use App\Instrument;
use App\AvailablePost;
use App\UsersInstrument;
use App\Services\SubscriptionsService;

class AvailablePostsService {

	public static function getAllAvailablePosts()
	{
		// if cache does not exist
		if (!Cache::has('available_posts_all')) {

			// get all the available posts in descending id (newest to oldest) and convert it to an array
			$available_posts = AvailablePost::orderBy('id', 'desc')
				->get()
				->toArray();

			// cache all the available posts
			Cache::put('available_posts_all', $available_posts, 20);
		}

		// return info from cache
		return Cache::get('available_posts_all');
	}

	public static function getAvailablePostsByInstrumentId($instrument_id)
	{
		// make sure id is numeric
		if (!is_numeric($instrument_id)) {
			throw new Exception('Invalid Instrument entered');
		}

		// make sure this is a valid instrument id by trying to get instrument info
		$instrument = Instrument::find($instrument_id);

		// if instrument is invalid (could not be found)
		if (!$instrument) {
			throw new Exception('This Instrument is not available for selection');
		}

		// if cache does not exist
		if (!Cache::has('available_posts_' . $instrument_id)) {

			// get all the available posts with this instrument id in descending id (newest to oldest) and convert it to an array
			$available_posts = AvailablePost::where('instrument_id', $instrument_id)
				->orderBy('id', 'desc')
				->get()
				->toArray();

			// cache all the available posts
			Cache::put('available_posts_' . $instrument_id, $available_posts, 20);
		}

		// return info from cache
		return Cache::get('available_posts_' . $instrument_id);
	}

	public static function getAvailablePostsByUserId($user_id)
	{	
		// if cache does not exist
		if (!Cache::has('users_available_posts_' . $user_id)) {
			
			// get user info
			$user = User::find($user_id);
			
			// if the user does not exist
			if (!$user) {
				throw new Exception('User does not exist');
			}

			// get all of the users active available posts
			$users_available_posts = AvailablePost::where('user_id', $user_id)
				->orderBy('id', 'desc')
				->get();
			
			// initialize available posts array
			$available_posts = [];

			foreach ($users_available_posts as $post) {
				// get the name of the instrument in question
				$instrument = Instrument::find($post->instrument_id);

				// format array for this post and add it to the users available posts
				$available_posts[] = [
					'id'          => $post->id,
					'instrument'  => $instrument->description,
					'created_at'  => $post->created_at->toDateTimeString(),
					'title'       => $post->title,
					'description' => $post->body,
				];
			}

			// cache available posts info
			Cache::put('users_available_posts_' . $user_id, $available_posts, 20);
		}

		// return info from cache
		return Cache::get('users_available_posts_' . $user_id);
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
		Cache::forget('available_posts_all');

		// forget the cache for this instruments available posts cache
		Cache::forget('available_posts_' . $instrument->id);

		// forget this users available posts
		Cache::forget('users_available_posts_' . $user_id);
	}

	public static function deleteAvailablePostsByPostId($post_id)
	{
		// make sure post id is numeric
		if (!is_numeric($post_id)) {
			throw new Exception('Invalid Available Post');
		}

		// get this posts info
		$available_post = AvailablePost::find($post_id);

		// make sure the post exists (could be found)
		if (!$available_post) {
			throw new Exception('Could not find posting (perhaps it has already been deleted)');
		}

		// make sure post belongs to the logged in user
		if (Auth::id() != $available_post->user_id) {
			throw new Exception('This posting is not yours to delete');
		}

		// delete the current available post
		try {
			$available_post->delete();
		} catch (Exception $e) {
			throw new Exception('Could not delete Available Post');
		}

		// forget the all available posts cache
		Cache::forget('available_posts_all');

		// forget the cache for this instruments available posts cache
		Cache::forget('available_posts_' . $available_post->instrument_id);

		// forget this users available posts
		Cache::forget('users_available_posts_' . $available_post->user_id);
	}
}
