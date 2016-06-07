<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddCodigosToTdbooksTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tdbook', function (Blueprint $table) {

            $table->string('codigos')->nullable()->after('sueltos');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tdbook', function (Blueprint $table) {
            $table->dropColumn('codigos');
        });
    }

}
