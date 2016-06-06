<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStepsCreateVideoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('steps_create_video', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('num_step')->unsigned();
			$table->string('description');
			$table->integer('time_estimated')->unsigned();
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
		Schema::drop('steps_create_video');
	}

}
