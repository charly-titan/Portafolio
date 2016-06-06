<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsProcessTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('LogsProcess', function($table) {
            // auto increment id (primary key)
                $table->bigIncrements('id');
                $table->string('action');
                $table->string('vod_id');
                $table->string('unixTimeStart');
                $table->longtext('log');
                $table->string('unixTimeEnd');
                $table->string('deltaUnixTime');
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
            Schema::drop('LogsProcess');
	}

}
