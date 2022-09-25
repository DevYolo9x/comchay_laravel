<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCategoryMediaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_media', function (Blueprint $table) {
            $table->id();
            $table->string('alanguage')->nullable();
            $table->string('title')->nullable();
            $table->string('slug')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->integer('parentid')->nullable();
            $table->integer('level')->nullable();
            $table->integer('lft')->nullable();
            $table->integer('rgt')->nullable();
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
        Schema::dropIfExists('category_media');
    }
}
