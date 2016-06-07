<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAddressTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('address',function($table){

				$table -> bigIncrements('id_address')->index();
				$table -> text('address');
				$table -> text('city');
				$table -> string('country');
				$table -> string('state');
				$table -> string('zip_code');
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
		Schema::drop('address');
	}

}
