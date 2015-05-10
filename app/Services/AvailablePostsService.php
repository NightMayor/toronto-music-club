<?php namespace App\Services;

use DB;
use App\User;
use Exception;
use App\AvailablePost;

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
		
		return true;
	}
}
