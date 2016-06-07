<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function($table)
		{
			$table->increments('id');
			$table->string('user_guid');
			$table->string('email');
			$table->string('email_hash');
			$table->string('password');
			$table->text('permissions')->nullable();
			$table->boolean('activated')->default(0);
			$table->string('activation_code')->nullable();
			$table->timestamp('activated_at')->nullable();
			$table->timestamp('last_login')->nullable();
			$table->string('persist_code')->nullable();
			$table->string('reset_password_code')->nullable();
			$table->mediumText('first_name')->nullable();
			$table->mediumText('last_name')->nullable();
			$table->enum('gender', array('male', 'female'));
			$table->string('country')->nullable();
			$table->string('state')->nullable();
			$table->integer('age')->nullable();
			$table->date('birthdate')->nullable();
			$table->string('contest')->nullable();
			$table->bigInteger('contest_id')->nullable();

			$table->timestamps();

			// We'll need to ensure that MySQL uses the InnoDB engine to
			// support the indexes, other engines aren't affected.
			$table->engine = 'InnoDB';
			$table->unique(array('email','contest_id'));
			$table->index('activation_code');
			$table->index('user_guid');
			$table->index(array('gender','contest_id'));
			$table->index(array('age','contest_id'));
			$table->index(array('country','contest_id'));
			$table->index('reset_password_code');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
