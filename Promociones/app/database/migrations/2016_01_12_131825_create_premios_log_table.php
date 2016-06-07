<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePremiosLogTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('premios_log', function(Blueprint $table)
		{
			$table->bigIncrements('id')->index();
			$table->bigInteger('premio_id');
			$table->string('sitio');
			$table->string('uid');
			$table->enum('status', array('pending', 'received', 'rejected'))->default('pending');
			$table->timestamps();

			// We'll need to ensure that MySQL uses the InnoDB engine to
			// support the indexes, other engines aren't affected.
			$table->engine = 'InnoDB';
			$table->index('premio_id');
			$table->index('uid');
			$table->index(array('premio_id','sitio'));
			$table->index(array('premio_id','sitio','uid'));
			$table->index(array('premio_id','sitio','status'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('premios_log');
	}

}
