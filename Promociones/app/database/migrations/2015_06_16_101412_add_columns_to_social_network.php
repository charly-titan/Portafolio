<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsToSocialNetwork extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('social_network', function($table) {
                $table->text('profile_url')->nullable()->after('contest');
                $table->text('photo_url')->nullable()->after('contest');
            });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('social_network', function($table) {
                $table->dropColumn('profile_url');
                $table->dropColumn('photo_url');
            });
	}

}
