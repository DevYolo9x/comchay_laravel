<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBriefingCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('briefing_categories', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('parentid');
            $table->string('slug');
            $table->string('image');
            $table->text('description');
            $table->string('meta_title');
            $table->string('meta_description');
            $table->integer('order');
            $table->tinyInteger('publish');
            $table->tinyInteger('ishome');
            $table->tinyInteger('highlight');
            $table->tinyInteger('isaside');
            $table->tinyInteger('isfooter');
            $table->integer('lft');
            $table->integer('rgt');
            $table->integer('level');
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
        Schema::dropIfExists('briefing_categories');
    }
}
