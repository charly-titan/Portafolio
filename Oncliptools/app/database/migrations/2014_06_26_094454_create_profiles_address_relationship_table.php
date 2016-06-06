<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesAddressRelationshipTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('groups_profile_address_relationships',function($table){

				$table -> bigIncrements('id_profile_address_relationship');
				$table -> integer('id_profile');
				$table -> integer('id_address');
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
