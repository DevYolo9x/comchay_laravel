<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->string('alanguage')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->integer('catalogueid')->nullable();
            $table->text('catalogue')->nullable();
            $table->string('image')->nullable();
            $table->text('image_json')->nullable();
            $table->integer('video_type')->nullable();
            $table->string('video_link')->nullable();
            $table->text('video_iframe')->nullable();
            $table->integer('viewed')->nullable();
            $table->tinyInteger('publish')->nullable();
            $table->tinyInteger('ishome')->nullable();
            $table->tinyInteger('highlight')->nullable();
            $table->tinyInteger('isaside')->nullable();
            $table->tinyInteger('isfooter')->nullable();
            $table->integer('order')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->integer('userid_created')->nullable();
            $table->integer('userid_updated')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('media');
    }
}
