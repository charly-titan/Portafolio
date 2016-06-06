<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGolesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('goles', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('id_partido')->unsigned();
			$table->integer('id_equipo')->unsigned();
			$table->text('parametros');
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
		Schema::drop('goles');
	}

}
