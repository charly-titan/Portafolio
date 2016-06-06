<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFeedsProgramBackupTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            //
            Schema::create('FeedsProgramBackup', function($table) {
            // auto increment id (primary key)
                $table->bigIncrements('id');
                $table->integer('programKey');
                $table->integer('secuency');
                $table->string('title');
                $table->text('img');
                $table->date('startDate');
                $table->time('startTime');
                $table->time('duration');
                $table->string('modified_by');
                $table->text('extra');
                // created_at, updated_at DATETIME
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
		//
            Schema::drop('FeedsProgramBackup');
	}

}
