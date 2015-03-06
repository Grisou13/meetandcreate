<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('projects', function(Blueprint $table){
	      $table->increments('id');
	      $table->text('description');
	      $table->string('progress');
	      
	      $table->string('title');
	      $table->text('slug');
	      $table->text('version');
	      $table->string('website');
	      $table->date('end_date');
	      $table->date('start_date');
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
		Schema::drop('projects');
	}

}
