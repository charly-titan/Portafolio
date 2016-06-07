<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlickrPhotosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flickr_photos', function(Blueprint $table)
		{
			$table-> bigIncrements('id');
			$table-> bigInteger('flickr_id');
			$table-> string('owner');
			$table-> string('secret');
			$table-> integer('server');
			$table-> integer('farm');
			$table-> integer('datetaken');
			$table-> integer('dateupload');
			$table-> boolean('download');
			$table-> enum('tipo', array('image', 'barcode'))->default('image');
			$table-> string('keyword');
			$table-> string('evento');
			$table-> text('s3_url');
			$table-> timestamps();


			// We'll need to ensure that MySQL uses the InnoDB engine to
			// support the indexes, other engines aren't affected.
			$table->engine = 'InnoDB';
			$table->index('flickr_id');
			$table->index('keyword');
			$table->index(array('flickr_id','dateupload'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('flickr_photos');
	}

}
