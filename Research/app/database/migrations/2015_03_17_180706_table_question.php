<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableQuestion extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questions', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->string('questionText');
			$table->string('helpText');
			$table->string('errorText');
			$table->string('questionType');
			$table->string('placeholder');
			$table->integer('numElemetMaxSel')->unsigned();
			$table->string('img');
			$table->string('order');
			$table->integer('status')->unsigned();
			$table->integer('contest_id')->unsigned();
			$table->integer('opcRandom')->unsigned();
			$table->integer('style_id')->unsigned();
			$table->string('request');
			$table->string('validationType');
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
		Shema::drop('questions');
	}

}
