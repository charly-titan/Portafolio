<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddOriginalPhotoToFlickrPhotosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('flickr_photos', function(Blueprint $table)
		{

			$table-> string('originalformat')->nullable()->after('farm');
			$table-> string('originalsecret')->nullable()->after('farm');
			$table-> text('s3_url_original')->nullable()->after('s3_url');

		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('flickr_photos', function(Blueprint $table)
		{
			$table->dropColumn('originalformat');
			$table->dropColumn('originalsecret');
			$table->dropColumn('s3_url_original');
		});
	}

}
