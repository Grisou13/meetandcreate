<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNotificationTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('notifications', function(Blueprint $table){
	      $table->increments('id');
	      $table->text('text');
	      $table->integer('profils_id')->unsigned();
	      $table->foreign('profils_id')->references('id')->on('profils');

	      $table->integer('notification_types_id')->unsigned();
	      $table->foreign('notification_types_id')->references('id')->on('notification_types');
	      $table->timestamps();
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('notifications');
	}

}
