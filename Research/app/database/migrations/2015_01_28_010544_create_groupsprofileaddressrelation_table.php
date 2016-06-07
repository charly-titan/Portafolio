<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupsprofileaddressrelationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groups_profile_address_relationships',function($table){

				$table -> bigIncrements('id_profile_address_relationship');
				$table -> bigInteger('id_profile');
				$table -> bigInteger('id_address');
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
			Schema::drop('groups_profile_address_relationships');
	}

}
