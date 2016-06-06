<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePartidosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('partidos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('equipo_local')->unsigned();
			$table->integer('equipo_visitante')->unsigned();
			$table->date('fecha_partido');
			$table->time('hora_partido');
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
		Schema::drop('partidos');
	}

}
