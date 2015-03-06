<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('messages', function(Blueprint $table){
	      $table->integer('profils_id')->unsigned();
	      $table->foreign('profils_id')->references('id')->on('profils');
	      $table->integer('destination_id')->unsigned();
	      $table->foreign('destination_id')->references('id')->on('profils');
	      $table->boolean('status');
	      $table->string('title');
	      $table->text('body');
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
		Schema::drop('messages');
	}

}
