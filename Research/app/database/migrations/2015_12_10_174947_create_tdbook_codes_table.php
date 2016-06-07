<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTdbookCodesTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdbook_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('codes')->unique()->nullable();
            $table->string('patrocinador');
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
        Schema::drop('tdbook_codes');
    }

}
