<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStickersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::create('stickers', function(Blueprint $table)
        {
            $table->bigIncrements('id')->index();
            $table->string('uid');
            $table->string('album');
            $table->string('stickers');
            $table->string('pegadas');
            $table->string('sueltas');
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
		Schema::drop('stickers');	}

    }
