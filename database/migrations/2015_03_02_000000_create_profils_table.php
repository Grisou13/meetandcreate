<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	    Schema::create('profils', function(Blueprint $table)
		{
	      $table->increments('id');
	      $table->integer('users_id', false, true);
	      $table->foreign('users_id')->references('id')->on('users');
	      $table->text('description');
	      $table->string('displayname');
	      $table->string('summary');
	      $table->boolean('private');
	      $table->string('email');
	      $table->text('slug');
	      $table->timestamps();
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
		
		Schema::dropIfExists('profils');
		
	}

}
