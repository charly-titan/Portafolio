<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContestRewardsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contest_rewards', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('contest_id')->unsigned();
			$table->integer('point_id')->unsigned();
			$table->integer('given_points');
			$table->integer('share_points');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('contest_rewards');
	}

}
