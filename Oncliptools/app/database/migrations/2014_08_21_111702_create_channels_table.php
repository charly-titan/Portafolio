<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChannelsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
            Schema::create('channels', function($table) {
                // auto increment id (primary key)
                $table->increments('id');
                $table->string('clave',255);
                $table->string('programa',255);

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
            Schema::drop('channels');
	}

}
