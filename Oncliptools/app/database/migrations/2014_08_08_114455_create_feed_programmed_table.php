<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedProgrammedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('feeds_programmed', function($table)
		{
			$table->bigIncrements('id');
			$table->integer('id_feed');
			$table->string('nameDays');
			$table->integer('timeConsultation');
			$table->string('hourOminute');
			$table->time('initiationTime');
			$table->time('endTime');
			$table->date('dateInitiation');
			$table->date('dateEnd');
			$table->date('lastError');
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
		Schema::drop('feeds_programmed');
	}

}
