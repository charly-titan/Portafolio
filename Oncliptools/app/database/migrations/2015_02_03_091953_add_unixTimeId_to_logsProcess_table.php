<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUnixTimeIdToLogsProcessTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		//
            Schema::table('LogsProcess', function($table) {
                $table->string('UnixTimeId');
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
            Schema::table('LogsProcess', function($table) {
                $table->dropColumn('UnixTimeId');
            });
	}

}
