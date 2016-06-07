<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePremiosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('premios', function(Blueprint $table)
		{
			$table->bigIncrements('id')->index();
			$table->string('nombre');
			$table->text('descripcion');
			$table->bigInteger('valor');
			$table->bigInteger('cantidad');
			$table->string('nombre_puntos');
			$table->text('img');
			$table->string('sitio');
			$table->bigInteger('stock');
			$table->timestamps();

			// We'll need to ensure that MySQL uses the InnoDB engine to
			// support the indexes, other engines aren't affected.
			$table->engine = 'InnoDB';
			$table->index('nombre');
			$table->index('sitio');
			$table->index(array('id','nombre'));
			$table->index(array('id','sitio'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('premios');
	}

}
