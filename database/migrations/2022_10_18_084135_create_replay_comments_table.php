<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReplayCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replay_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('comment_id');
            $table->string('name');
            $table->string('email');
            $table->text('replay');
            $table->timestamps();
            // relasi dengan table comments
            $table->foreign('comment_id')->references('id')->on('comments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('replay_comments');
    }
}
