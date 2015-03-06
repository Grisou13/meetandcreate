<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserFriendsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('user_friends', function(Blueprint $table){
	      $table->integer('profils_id')->unsigned();
	      $table->foreign('profils_id')->references('id')->on('profils');
	      $table->integer('friends_id')->unsigned();
	      $table->foreign('friends_id')->references('id')->on('profils');
	      $table->boolean('is_accepted');
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('user_friends');
	}

}
