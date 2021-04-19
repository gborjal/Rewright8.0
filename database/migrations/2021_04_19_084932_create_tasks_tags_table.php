<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasksTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /*Schema::create('tasks_tags', function (Blueprint $table) {
            $table->integer('tasks_id')->unsigned();        //tags used in this task
            $table->integer('tag_info_id')->unsigned(); 
            $table->increments('id');
            $table->boolean('active');
            $table->timestamps();
            
            $table->foreign('tasks_id')
                ->references('id')
                ->on('tasks_board')
                ->onDelete('cascade');
            $table->foreign('tag_info_id')
                ->references('id')
                ->on('tag_info')
                ->onDelete('cascade');
        });*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('tasks_tags');
    }
}
