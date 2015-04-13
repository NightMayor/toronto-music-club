<?php

use App\SubscriptionPrice;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class SubscriptionPricesTableSeeder extends Seeder {

    public function run()
    {
        DB::table('subscription_prices')->delete();

    	$subscription_prices = [
    		[
				'subscription_id' => 1,
				'amount'          => 0,
    		],
    		[
    			'subscription_id' => 2,
				'amount'          => 500,
    		]
    	];

        foreach ($subscription_prices as $subscription_price) {
            SubscriptionPrice::create($subscription_price);
        }
    }

}