<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('videos', function(Blueprint $table)
		{
			$table->bigIncrements('id');
			$table->string('reference_guid');
			$table->string('short_name');
			$table->integer('user_id')->unsigned();
			$table->string('pid');
			$table->string('title');
			$table->enum('video_type', array('short', 'full'));
			$table->timestamps();
			$table->unique('reference_guid');
			$table->index('short_name');
			$table->index('user_id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('videos');
	}

}
