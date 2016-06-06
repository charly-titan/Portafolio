<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBitratesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('bitrates', function( $table)
		{
			$table->bigIncrements('id');
			$table->string('signal_id');
			$table->string('quality');
			$table->string('bitrate');
			$table->timestamps();
			$table->index('signal_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('signals');
	}

}
