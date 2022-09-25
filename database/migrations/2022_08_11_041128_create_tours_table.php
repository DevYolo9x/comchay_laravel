<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateToursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('alanguage');
            $table->string('title');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->text('content')->nullable();
            $table->text('video')->nullable();
            $table->string('banner')->nullable();
            $table->string('image')->nullable();
            $table->text('image_json')->nullable();

            $table->foreignIdFor(\App\Models\TourCategory::class, 'category_id');
            $table->text('category_json')->nullable();

            $table->foreignIdFor(\App\Models\TourLocation::class, 'location_id');
            $table->text('location_json')->nullable();

            $table->string('code')->nullable();
            $table->integer('price')->nullable();
            $table->integer('price_sale')->nullable();
            $table->integer('price_contact')->nullable();

            $table->tinyInteger('publish')->nullable();
            $table->tinyInteger('ishome')->nullable();
            $table->tinyInteger('highlight')->nullable();
            $table->tinyInteger('isaside')->nullable();
            $table->tinyInteger('isfooter')->nullable();
            //tour
            $table->text('map')->nullable();
            $table->text('schedule')->nullable();
            //end
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
        Schema::dropIfExists('tours');
    }
}
