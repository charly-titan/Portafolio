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
				$table -> bigInteger('id_users');
				$table -> string('first_name')->index();
				$table -> text('last_name');
				$table -> date('birthdate');
				$table -> string('gender');
				$table -> text('phone');
				$table -> text('fax');
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
