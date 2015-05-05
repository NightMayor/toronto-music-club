<?php namespace App\Services;

use Cache;
use Input;
use App\User;
use Exception;
use App\Gender;
use App\UserChangeLog;
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

	public static function updateProfile($user_id)
	{
		// set value to determine if user needs to be updated to 0 by default
		$update_user = 0;

		// get user info
		$user = User::find($user_id);
		
		// if the user does not exist
		if (!$user) {
			throw new Exception('User does not exist');
		}

		// save a Json object of the user info incase there is an update
		$old_user = $user->toJson();

		// make sure name has been sent
		if (!Input::has('name') || Input::get('name') == '') {
			throw new Exception('Name is a required field');
		}

		// if the users name has changed
		if (Input::get('name') != $user->name) {
			// update the users name
			$user->name = Input::get('name');
			$update_user = 1;
		}

		// make sure gender has been sent and is numeric
		if (!is_numeric(Input::get('gender'))) {
			throw new Exception('Gender is a required field');
		}

		// make sure gender is a valid selection
		$gender = Gender::find(Input::get('gender'));

		// if gender does not exist
		if (!$gender) {
			throw new Exception('That is not one of the options for Gender');
		}

		// if the users gender has changed
		if ($gender->id != $user->gender_id) {
			// update the users gender
			$user->gender_id = $gender->id;
			$update_user = 1;
		}

		// if age is not numeric set age to null by default (this also makes sure we have a value for age)
		if (!is_numeric(Input::get('age'))) {
			$age = null;
		} else {
			// set age according to age provided
			$age = Input::get('age');
		}

		// if the users age has changed
		if ($age != $user->age) {
			// update the users age
			$user->age = $age;
			$update_user = 1;
		}

		// set bio to null by default
		$bio = null;

		// make sure bio is not an empty string
		if (Input::get('bio') != '') {
			// set bio from input
			$bio = Input::get('bio');
		}

		// make sure bio is not greater than 500 characters
		if (strlen($bio) > 500) {
			throw new Exception('Please limit your Bio to 500 characters');		
		}

		// if the bio has changed
		if ($bio != $user->bio) {
			// update the users bio
			$user->bio = $bio;
			$update_user = 1;
		}

		// check if the user needs to be updated
		if ($update_user == 1) {

			// create a log of the change
			$update_log              = new UserChangeLog;
			$update_log->user_id     = $user_id;
			$update_log->description = $old_user;
			$update_log->save();

			// update the user
			$user->save();
		}

		// forget the users cached profile
		Cache::forget('profile_' . $user_id);
	}
}
