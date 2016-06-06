<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSignalsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('signals', function( $table)
		{
			$table->bigIncrements('id');
			$table->string('url_signal');
			$table->string('url_signal_hds');
			$table->string('name');
			$table->string('short_name');
			$table->string('quality_range');
			$table->timestamps();
			$table->index('short_name');
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
