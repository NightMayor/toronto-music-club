<?php namespace App\Services;

use DB;
use Validator;

use App\User;
use App\UsersSubscription;

use Illuminate\Contracts\Auth\Registrar as RegistrarContract;

class Registrar implements RegistrarContract {

	/**
	 * Get a validator for an incoming registration request.
	 *
	 * @param  array  $data
	 * @return \Illuminate\Contracts\Validation\Validator
	 */
	public function validator(array $data)
	{
		return Validator::make($data, [
			'name' => 'required|max:255',
			'email' => 'required|email|max:255|unique:users',
			'password' => 'required|confirmed|min:6',
		]);
	}

	/**
	 * Create a new user instance after a valid registration.
	 *
	 * @param  array  $data
	 * @return User
	 */
	public function create(array $data)
	{
		$user_info = DB::transaction(function($data) use ($data)
		{
			// create the new user
			$user = User::create([
				'name'     => $data['name'],
				'email'    => $data['email'],
				'password' => bcrypt($data['password']),
			]);

			// create the new users subscription (default 1 for Basic)
			$user_subscription                  = new UsersSubscription();
			$user_subscription->user_id         = $user->id;
			$user_subscription->subscription_id = 1;
			$user_subscription->save();

			return $user;
		});

		return $user_info;
	}

}
