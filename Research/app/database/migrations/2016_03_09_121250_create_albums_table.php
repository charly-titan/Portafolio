<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAlbumsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		      Schema::create('albums', function(Blueprint $table)
        {
            $table->bigIncrements('id')->index();
            $table->string('album');
            $table->string('sitio');
            $table->string('color');
            $table->string('portada');
            $table->text('stickers');
            $table->text('orden');
            $table->text('carrusel');
            $table->text('data');
            $table->string('referencia');
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
        Schema::drop('albums');
	}

}
