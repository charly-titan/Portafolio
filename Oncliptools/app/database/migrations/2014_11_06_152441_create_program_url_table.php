<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProgramUrlTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('programs_url', function($table) {
            $table->increments('id_url');
            $table->integer('id')->unsigned();
            $table->boolean('Monday');
            $table->boolean('Tuesday');
            $table->boolean('Wednesday');
            $table->boolean('Thursday');
            $table->boolean('Friday');
            $table->boolean('Saturday');
            $table->boolean('Sunday');
            $table->String('url');
            $table->integer('inactive_date');
            $table->time('startTime');
            $table->time('endTime');
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {

        Schema::drop('programs_url');
    }

}
