<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupSitesRelationshipTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groups_sites_relationships',function($table){

				$table -> bigIncrements('id_group_site_relationship')->index();
				$table -> integer('id_group');
				$table -> integer('id_site');
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
		Shema::drop('groups_sites_relationships');
	}


}
