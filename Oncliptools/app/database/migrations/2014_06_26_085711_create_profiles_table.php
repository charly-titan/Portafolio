<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('profiles',function($table){ 

				$table -> bigIncrements('id_profile');
				$table -> integer('id_users');
				$table -> string('first_name')->index();
				$table -> string('last_name');
				$table -> date('birthdate');
				$table -> string('gender');
				$table -> string('phone');
				$table -> string('fax');
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
		Schema::drop('profiles');
	}

}
