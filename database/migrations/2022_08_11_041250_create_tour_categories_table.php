<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_categories', function (Blueprint $table) {
            $table->id();
            $table->string('alanguage');
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->string('banner')->nullable();
            $table->string('image')->nullable();
            $table->text('image_json')->nullable();
            $table->integer('parent_id')->nullable();
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
        Schema::dropIfExists('tour_categories');
    }
}
