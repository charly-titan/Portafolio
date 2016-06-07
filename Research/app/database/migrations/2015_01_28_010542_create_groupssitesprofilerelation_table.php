<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupssitesprofilerelationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groups_sites_profile_relationships',function($table){

				$table -> bigIncrements('id_group_site_profile_relationship');
				$table -> bigInteger('id_site');
				$table -> bigInteger('id_group');
				$table -> bigInteger('id_profile');
				$table -> timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('groups_sites_profile_relationships');
	}

}
