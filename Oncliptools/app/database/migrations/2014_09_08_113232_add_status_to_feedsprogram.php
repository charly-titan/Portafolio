<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusToFeedsprogram extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
            Schema::table('FeedsProgram', function($table) {
                $table->integer('status');
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
//            Schema::table('FeedsProgram', function($table)
//            {
//                $table->dropColumn('status');
//            });
	}

}
