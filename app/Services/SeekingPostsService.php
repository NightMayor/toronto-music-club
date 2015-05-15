<?php namespace App\Services;

use DB;
use Auth;
use Cache;
use Input;
use Exception;

use App\User;
use App\Instrument;
use App\SeekingPost;
use App\UsersInstrument;
use App\Services\SubscriptionsService;

class SeekingPostsService {

	public static function getAllSeekingPosts()
	{
		// if cache does not exist
		if (!Cache::has('seeking_posts_all')) {

			// get all the seeking posts in descending id (newest to oldest) and convert it to an array
			$seeking_posts = SeekingPost::orderBy('id', 'desc')
				->get()
				->toArray();

			// cache all the seeking posts
			Cache::put('seeking_posts_all', $seeking_posts, 20);
		}

		// return info from cache
		return Cache::get('seeking_posts_all');
	}

	public static function getSeekingPostsByInstrumentId($instrument_id)
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
		if (!Cache::has('seeking_posts_' . $instrument_id)) {

			// get all the seeking posts with this instrument id in descending id (newest to oldest) and convert it to an array
			$seeking_posts = SeekingPost::where('instrument_id', $instrument_id)
				->orderBy('id', 'desc')
				->get()
				->toArray();

			// cache all the seeking posts
			Cache::put('seeking_posts_' . $instrument_id, $seeking_posts, 20);
		}

		// return info from cache
		return Cache::get('seeking_posts_' . $instrument_id);
	}

	public static function getSeekingPostsByUserId($user_id)
	{		
		// if cache does not exist
		if (!Cache::has('users_seeking_posts_' . $user_id)) {
			
			// get user info
			$user = User::find($user_id);
			
			// if the user does not exist
			if (!$user) {
				throw new Exception('User does not exist');
			}

			// get all of the users active seeking posts
			$users_seeking_posts = SeekingPost::where('user_id', $user_id)
				->orderBy('id', 'desc')
				->get();
			
			// initialize seeking posts array
			$seeking_posts = [];

			foreach ($users_seeking_posts as $post) {
				// get the name of the instrument in question
				$instrument = Instrument::find($post->instrument_id);

				// format array for this post and add it to the users seeking posts
				$seeking_posts[] = [
					'id'          => $post->id,
					'instrument'  => $instrument->description,
					'created_at'  => $post->created_at->toDateTimeString(),
					'title'       => $post->title,
					'description' => $post->body,
				];
			}

			// cache seeking posts info
			Cache::put('users_seeking_posts_' . $user_id, $seeking_posts, 20);
		}

		// return info from cache
		return Cache::get('users_seeking_posts_' . $user_id);
	}

	public static function createSeekingPost($user_id)
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

		// get all the users active seeking posts
		$active_posts = SeekingPost::where('user_id', $user_id)
			->get();

		// get users subscription info
		$subscription = SubscriptionsService::getSubscriptionByUserId($user_id);

		// make sure user has not used up their limit of seeking posts
		if (count($active_posts) >= $subscription[0]->seeking_posts) {
			throw new Exception($subscription[0]->description . ' accounts may not have more than ' . $subscription[0]->seeking_posts . ' concurrent Seeking Posts');			
		}

		// make sure instrument is a valid selection
		$instrument = Instrument::find(Input::get('instrument'));

		// if instrument does not exist
		if (!$instrument) {
			throw new Exception('That is not one of the options for Instrument');
		}

		// make sure the title of the post was sent
		if (!Input::has('title')) {
			throw new Exception('Your Seeking Post must have a title');
		}

		// set title from input
		$title = Input::get('title');

		// make sure title is not greater than 50 characters
		if (strlen($title) > 50) {
			throw new Exception('Please limit your Seeking Post title to 50 characters');		
		}

		// make sure the body of the post was sent
		if (!Input::has('body')) {
			throw new Exception('Your Seeking Post must have a description');
		}

		// set body from input
		$body = Input::get('body');

		// make sure body is not greater than 500 characters
		if (strlen($body) > 500) {
			throw new Exception('Please limit your Seeking Post description to 500 characters');		
		}
		
		try {
			// create new seeking post
			$new_post                = new SeekingPost;
			$new_post->user_id       = $user_id;
			$new_post->instrument_id = $instrument->id;
			$new_post->title         = $title;
			$new_post->body          = $body;
			$new_post->save();
		} catch (Exception $e) {
			throw new Exception('Could not create Seeking Post');
		}

		// forget the all seeking posts cache
		Cache::forget('seeking_posts_all');

		// forget the cache for this instruments seeking posts cache
		Cache::forget('seeking_posts_' . $instrument->id);

		// forget this users seeking posts
		Cache::forget('users_seeking_posts_' . $user_id);
	}

	public static function deleteSeekingPostsByPostId($post_id)
	{
		// make sure post id is numeric
		if (!is_numeric($post_id)) {
			throw new Exception('Invalid Seeking Post');
		}

		// get this posts info
		$seeking_post = SeekingPost::find($post_id);

		// make sure the post exists (could be found)
		if (!$seeking_post) {
			throw new Exception('Could not find posting (perhaps it has already been deleted)');
		}

		// make sure post belongs to the logged in user
		if (Auth::id() != $seeking_post->user_id) {
			throw new Exception('This posting is not yours to delete');
		}

		// delete the current seeking post
		try {
			$seeking_post->delete();
		} catch (Exception $e) {
			throw new Exception('Could not delete Seeking Post');
		}

		// forget the all seeking posts cache
		Cache::forget('seeking_posts_all');

		// forget the cache for this instruments seeking posts cache
		Cache::forget('seeking_posts_' . $seeking_post->instrument_id);

		// forget this users seeking posts
		Cache::forget('users_seeking_posts_' . $seeking_post->user_id);
	}
}
