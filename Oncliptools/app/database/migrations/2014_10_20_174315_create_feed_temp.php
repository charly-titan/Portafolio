<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedTemp extends Migration {

	public function up()
	{
		Schema::create('feed_temp', function(Blueprint $table)
		{
			$table->engine = 'MyISAM';
			$table->integer('cl');
			$table->string('urlFeed')->unique();
		});

		DB::statement('ALTER TABLE FeedsProgram ENGINE = MyISAM');
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('feed_temp');
	}


}
