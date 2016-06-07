<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupssitesrelationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groups_sites_relationships',function($table){

				$table -> bigIncrements('id_group_site_relationship')->index();
				$table -> bigInteger('id_group');
				$table -> bigInteger('id_site');
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
		Schema::drop('groups_sites_relationships');
	}

}
