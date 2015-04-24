<?php namespace App\Services;

use Cache;
use App\User;
use Exception;

class ProfileService {

	public static function getProfileById($id)
	{
		if (!Cache::has('profile_' . $id)) {
			$user = User::find($id);
			Cache::put('profile_' . $id, $user, 2);
		} 

		throw new Exception('I threw the error from profile service!');
		return Cache::get('profile_' . $id);
	}
}
