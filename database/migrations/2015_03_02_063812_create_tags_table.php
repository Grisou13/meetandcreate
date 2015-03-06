<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tags',  function (Blueprint $table){
      $table->increments('id');
      $table->string('name');
      $table->text('description');
    });
    Schema::create('project_tags',function(Blueprint $table){
      $table->integer('projects_id', false, true);
      $table->foreign('projects_id')->references('id')->on('projects');
      $table->integer('tags_id', false, true);
      $table->foreign('tags_id')->references('id')->on('tags');
    });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('project_tags');
		Schema::drop('tags');
		
	}

}
