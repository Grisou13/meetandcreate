<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectMembersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('project_members', function(Blueprint $table){
      $table->increments('id');
      
      $table->integer('profils_id', false, true);
      $table->foreign('profils_id')->references('id')->on('profils');
      $table->integer('projects_id', false, true);
      $table->foreign('projects_id')->references('id')->on('projects');
      $table->integer('suggestion_id', false, true);
      $table->foreign('suggestion_id')->references('id')->on('profils');
      
      $table->boolean('is_accepted_by_project_admin');
      $table->boolean('is_accepted_by_user');
      $table->string('reason')->nullable();
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
		Schema::drop('project_members');
	}

}
