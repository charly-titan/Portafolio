<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosQualitiesBitratesRelationshipTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('videos_qualities_bitrates_relationship', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('video_id')->unsigned();
			$table->string('quality');
			$table->string('bitrate');
			$table->string('pid');
			$table->integer('akamai')->unsigned();
			$table->string('quaity_akamai');
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
		Schema::drop('videos_qualities_bitrates_relationship');
	}

}
