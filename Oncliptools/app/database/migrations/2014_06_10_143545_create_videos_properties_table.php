<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosPropertiesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('videos_properties', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->integer('video_id')->unsigned();
			$table->string('reference_guid');
			$table->string('property_name');
			$table->string('property_value');
			$table->timestamps();
			$table->index('reference_guid');
			$table->index('property_name');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		//
		Schema::drop('videos_properties');
	}

}
