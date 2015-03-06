<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStatusesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('status',function(Blueprint $table){
	      $table->increments('id');
	      $table->string('name');
	      $table->text('description');
	    });
	    Schema::create('project_status', function(Blueprint $table){
	      $table->integer('projects_id', false, true);
	      $table->foreign('projects_id')->references('id')->on('projects');
	      $table->integer('status_id', false, true);
	      $table->foreign('status_id')->references('id')->on('status');
	      $table->date('date');
	      $table->string('progress');
	    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('project_status');
		Schema::drop('status');
	}

}
