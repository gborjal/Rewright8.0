<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('owner_id')->unsigned();
            $table->string('text');
            $table->integer('size');
            $table->boolean('active');
            $table->timestamps('update_ts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('notes');
        Schema::dropIfExists('task_exer_data');
        Schema::dropIfExists('exer_data');
        Schema::dropIfExists('task_assignment');
        Schema::dropIfExists('tag_info');
        Schema::dropIfExists('task_tag');
        Schema::dropIfExists('tasks_board');
        Schema::dropIfExists('discussion_notifs');
        Schema::dropIfExists('discussion_votes');
        Schema::dropIfExists('discussion_comments');
        Schema::dropIfExists('discussions_board');
        Schema::dropIfExists('developers');
        Schema::dropIfExists('projects');
    }
}
