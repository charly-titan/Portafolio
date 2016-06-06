<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('images', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('time_created')->unsigned();
			$table->integer('signal_id')->unsigned();
			$table->integer('thumb_num');
			$table->text('thumb_urls');
			$table->boolean('status');
			$table->text('info');
			$table->index('time_created');
			$table->index('signal_id');
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
		Schema::drop('images');
	}

}
