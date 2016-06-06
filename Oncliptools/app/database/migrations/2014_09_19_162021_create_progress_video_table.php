<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgressVideoTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('progress_video', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('video_id')->unsigned();
			$table->integer('step_current')->unsigned();
			$table->string('pid');
			$table->integer('process_start')->unsigned();
			$table->integer('process_end')->unsigned();
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
		Schema::drop('progress_video');
	}

}
