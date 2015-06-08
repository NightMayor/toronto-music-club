<?php

use App\UsersSubscription;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class UsersSubscriptionsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('users_subscriptions')->delete();

    	$users_subscriptions = [
    		[
                'user_id'         => 100001,
                'subscription_id' => 1,
    		],
    	];

        foreach ($users_subscriptions as $users_subscription) {
            UsersSubscription::create($users_subscription);
        }
    }

}