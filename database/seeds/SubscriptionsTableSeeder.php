<?php

use App\Subscription;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SubscriptionsTableSeeder extends Seeder {

    public function run()
    {
    	DB::table('subscriptions')->delete();

    	$subscriptions = [
    		[
                'description'           => 'Basic',
                'primary_instruments'   => 2,
                'secondary_instruments' => 5,
                'seeking_posts'         => 4,
                'available_posts'       => 3,
    		],
    		[
                'description'           => 'Professional',
                'primary_instruments'   => 5,
                'secondary_instruments' => 10,
                'seeking_posts'         => 10,
                'available_posts'       => 10,
    		]
    	];

        foreach ($subscriptions as $subscription) {
            Subscription::create($subscription);
        }
    }
}