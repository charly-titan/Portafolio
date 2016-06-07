<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableContestProperties extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contest_properties', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('id_contest')->unsigned();
			$table->string('property_name')->index();
			$table->string('property_value');
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
		Shema::drop('contest_properties');
	}

}
