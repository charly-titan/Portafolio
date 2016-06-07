<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFlickrAuthTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('flickr_auth', function(Blueprint $table)
		{
			$table->increments('id');
			$table-> string('api_key');
			$table-> string('api_secret');
			$table-> string('frob');
			$table-> string('auth_token');
			$table-> string('user_id');
			$table->timestamps();

			$table->engine = 'InnoDB';
			$table->index('api_key');
			$table->index('api_secret');
			$table->index(array('api_key','auth_token','user_id'));
			$table->index(array('api_key','frob'));
			$table->index(array('api_key','auth_token'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('flickr_auth');
	}

}
