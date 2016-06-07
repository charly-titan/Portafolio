<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTdbookTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tdbook', function (Blueprint $table) {
            $table->increments('id');
            $table->string('user_id')->unique()->nullable();
            $table->string('pegados');
            $table->string('sueltos');
            $table->timestamps();
        });}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('tdbook');
    }

}
