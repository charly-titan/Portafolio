<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVersusTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('versus', function(Blueprint $table)
		{
			$table->increments('id');
			$table->bigInteger('user_id');
			$table->bigInteger('contest_id');
			$table->integer('question_id');
			$table->integer('option_id');
			$table->integer('votos');
			$table->text('ip');
			$table->text('browser');
			$table->timestamps();

			// We'll need to ensure that MySQL uses the InnoDB engine to
			// support the indexes, other engines aren't affected.
			$table->engine = 'InnoDB';
			$table->index('user_id');
			$table->index(array('user_id','contest_id'));
			$table->index(array('question_id','contest_id'));
			
			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('versus');
	}

}
