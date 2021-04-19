<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscussionCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discussion_comments', function (Blueprint $table) {
            $table->integer('discussion_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->increments('id');
            $table->mediumText('text')->nullable();
            $table->string('image')->nullable();
            $table->integer('upvote')->nullable();
            $table->integer('downvote')->nullable();
            $table->timestamps();
            
            $table->foreign('discussion_id')
                ->references('id')
                ->on('discussions_board')
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
        //Schema::dropIfExists('discussion_comments');
    }
}
