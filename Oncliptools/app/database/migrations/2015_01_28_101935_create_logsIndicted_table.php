<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogsIndictedTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::create('LogsIndicted', function($table) {
            // auto increment id (primary key)
                $table->bigIncrements('id');
                $table->string('logsFile');
                $table->string('size');
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
            Schema::drop('LogsIndicted');
	}

}
