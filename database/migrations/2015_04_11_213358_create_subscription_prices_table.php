<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubscriptionPricesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('subscription_prices', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('subscription_id')->unsigned();
			$table->foreign('subscription_id')->references('id')->on('subscriptions');
			$table->integer('amount')->unsigned();
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
		Schema::dropIfExists('subscription_prices');
	}

}
