<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableQuestionOptions extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questions_options', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('question_id');
			$table->string('text');
			$table->string('value');
			$table->string('order');
			$table->integer('status')->unsigned();			
			$table->string('img');
			$table->string('video');
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
		Schema::drop('questions_options');
	}

}
