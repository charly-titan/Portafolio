<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableContest extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contest', function(Blueprint $table)
		{
			$table->bigIncrements('id_contest');
			$table->string('short_name')->unique()->index();
			$table->integer('start_date');
			$table->integer('end_date');
			$table->integer('activation_date');
			$table->string('contest_type');
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
		Shema::drop('contest');
	}

}
