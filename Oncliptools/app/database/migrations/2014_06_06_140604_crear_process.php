<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearProcess extends Migration {

	/**
	 * Run the migrations.
	 * 
	 * @return void
	 */
	//Crea la tabla process, que guarda la info de los videos generados
	public function up()
	{
		Schema::create('process', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('process_id');
			$table->integer('system_time')->unsigned();
			$table->integer('start_time')->unsigned();
			$table->integer('end_time')->unsigned();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('process');
	}

}

