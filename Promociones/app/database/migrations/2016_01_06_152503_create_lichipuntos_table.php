<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLichipuntosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('lichipuntos', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('uid');
			$table->string('action');
			$table->string('url');
			$table->text('embed');
			$table->integer('video_id')->nullable();
			$table->timestamps();

			// We'll need to ensure that MySQL uses the InnoDB engine to
			// support the indexes, other engines aren't affected.
			$table->engine = 'InnoDB';
			$table->index('uid');
			$table->index(array('uid','action','url'));
			$table->index(array('uid','action','video_id'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('lichipuntos');
	}

}
