<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscussionsBoardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discussions_board', function (Blueprint $table) {
            $table->integer('project_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->increments('id');
            $table->string('title');
            $table->mediumText('text')->nullable();
            $table->string('image')->nullable();
            $table->integer('priority')->nullable();
            $table->boolean('active');
            $table->timestamps();
            
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('cascade');
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //Schema::dropIfExists('discussions_board');
    }
}
