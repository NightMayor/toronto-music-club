<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionPaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subscription_payments', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('users_subscription_id')->unsigned();
			$table->foreign('users_subscription_id')->references('id')->on('users_subscriptions');
			$table->integer('amount_paid')->unsigned();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('subscription_payments');
	}

}
