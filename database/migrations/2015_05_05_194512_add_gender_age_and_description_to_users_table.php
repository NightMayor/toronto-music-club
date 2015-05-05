<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGenderAgeAndDescriptionToUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->integer('gender_id')->unsigned()->default(1);
			$table->foreign('gender_id')->references('id')->on('genders');
			$table->integer('age')->unsigned()->nullable();
			$table->string('bio', 500)->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->dropColumn(['gender_id', 'age', 'bio']);
		});
	}

}
