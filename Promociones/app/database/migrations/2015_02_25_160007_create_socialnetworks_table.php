<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSocialnetworksTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('social_network', function($table)
		{
			$table->increments('id');
			$table->bigInteger('social_id');
			$table->bigInteger('user_id');
			$table->string('user_guid');
			$table->bigInteger('contest_id');
			$table->string('social_network');
			$table->string('contest')->nullable();
			$table->timestamps();

			// We'll need to ensure that MySQL uses the InnoDB engine to
			// support the indexes, other engines aren't affected.
			$table->engine = 'InnoDB';
			$table->unique(array('social_id','contest_id','user_guid'));
			$table->index('user_id');
			$table->index('user_guid');
			$table->index('social_network');
			$table->index(array('user_id','contest_id'));
			$table->index(array('user_guid','contest_id'));

			
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('social_network');
	}

}
