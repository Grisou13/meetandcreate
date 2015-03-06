<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSocialidsUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users', function(Blueprint $table)
		{
			$table->string('username')->unique();
			$table->string('git_id');
			$table->string('fb_id');
			$table->string('g_id');
			$table->rememberToken();

      		$table->softDeletes();
		});
    
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	    Schema::table('users',function(Blueprint $table)
	    {
	      $table->dropColumn(['username','git_id','fb_id','g_id','remember_token']);

	      $table->dropSoftDeletes();
	    });
	}

}
