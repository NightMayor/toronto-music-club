<?php namespace App\Services;

use Cache;
use App\User;
use Exception;
use App\Gender;
use App\Services\InstrumentsService;
use App\Services\SubscriptionsService;

class ProfilesService {

	public static function getProfileByUserId($user_id)
	{
		// Cache::forget('profile_' . $user_id);
		if (!Cache::has('profile_' . $user_id)) {
			
			// get user info
			$user = User::find($user_id);
			
			// if the user does not exist
			if (!$user) {
				throw new Exception('User does not exist');
			}

			// get the users subscription
			$user_subscription = SubscriptionsService::getSubscriptionByUserId($user_id);

			// get the users gender
			$gender = Gender::find($user->gender_id);

			// format the users info as an array
			$user_info = [
				'user_id'      => $user->id,
				'name'         => $user->name,
				'email'        => $user->email,
				'member_since' => $user->created_at->toDateTimeString(),
				'account_type' => $user_subscription[0]->description,
				'gender'       => $gender->description,
				'bio'          => $user->bio,
				'age'          => $user->age,
			];

			// get users instruments
			$users_instruments = InstrumentsService::getUsersInstruments($user_id);

			// format the profile as an array
			$profile = [
				'user_info'         => $user_info,
				'users_instruments' => $users_instruments,
			];

			// cache profile info
			Cache::put('profile_' . $user_id, $profile, 20);
		}

		return Cache::get('profile_' . $user_id);
	}
}
