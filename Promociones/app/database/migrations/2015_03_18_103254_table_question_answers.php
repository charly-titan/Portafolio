<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableQuestionAnswers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('questions_answers', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('contest_id');
			$table->integer('user_id');
			$table->integer('question_id');
			$table->integer('option_id');
			$table->string('type');
			$table->integer('value');
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
		Shema::drop('questions_answers');
	}

}
