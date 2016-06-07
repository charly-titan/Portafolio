<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlickrRegisterTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flickr_register', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('code');
			$table->string('keyword');
			$table->bigInteger('register_id');
			$table->text('photos_url');
			$table->timestamps();

			// We'll need to ensure that MySQL uses the InnoDB engine to
			// support the indexes, other engines aren't affected.
			$table->engine = 'InnoDB';
			$table->index('code');
			$table->index('keyword');
			$table->index(array('register_id','code'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('flickr_register');
	}

}
