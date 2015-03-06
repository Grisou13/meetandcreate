<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProjectObjectivesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_objectives', function(Blueprint $table){
	      $table->increments('id');
	      $table->string('name');
	      $table->text('description');
	      $table->boolean('is_reached');
	      $table->integer('projects_id', false, true);
	      $table->foreign('projects_id')->references('id')->on('projects');
    	});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('project_objectives');
	}

}
