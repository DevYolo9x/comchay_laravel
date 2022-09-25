<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBriefingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('briefings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\BriefingCategory::class, 'category_id');
            $table->string('title');
            $table->string('slug');
            $table->string('image');
            $table->text('description');
            $table->tinyInteger('publish');
            $table->integer('order');
            $table->tinyInteger('ishome');
            $table->tinyInteger('highlight');
            $table->tinyInteger('isaside');
            $table->tinyInteger('isfooter');
            $table->string('meta_title');
            $table->string('meta_description');
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
        Schema::dropIfExists('briefings');
    }
}
