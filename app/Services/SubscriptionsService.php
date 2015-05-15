<?php namespace App\Services;

use DB;
use Exception;

use App\User;
use App\Subscription;

class SubscriptionsService {

	public static function getAllSubscriptionTypes()
	{
		if (!Cache::has('subscription_list')) {
			$subscriptions = Subscription::all();
			Cache::put('subscription_list', $subscriptions, 10);
		}

		return Cache::get('subscription_list');
	}

	public static function getSubscriptionByUserId($user_id)
	{	
		// get user info
		$user = User::find($user_id);
		
		// if the user does not exist
		if (!$user) {
			throw new Exception('User does not exist');
		}

		$users_subscription = DB::table('users_subscriptions')
			->join('subscriptions', 'users_subscriptions.subscription_id', '=', 'subscriptions.id')
			->select('subscriptions.*')
			->where('users_subscriptions.user_id', $user_id)
			->whereNull('users_subscriptions.deleted_at')
			->whereNull('subscriptions.deleted_at')
			->get();

		return $users_subscription;
	}
}
