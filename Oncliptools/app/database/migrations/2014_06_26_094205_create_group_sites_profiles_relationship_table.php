<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupSitesProfilesRelationshipTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groups_sites_profile_relationships',function($table){

				$table -> bigIncrements('id_group_site_profile_relationship');
				$table -> integer('id_site');
				$table -> integer('id_group');
				$table -> integer('id_profile');
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
		$chema::drop('groups_sites_profile_relationships');
	}

}
