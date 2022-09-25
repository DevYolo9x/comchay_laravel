<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourServiceItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_service_items', function (Blueprint $table) {
            $table->id();
            $table->string('alanguage');
            $table->string('title');
            $table->foreignIdFor(\App\Models\TourService::class, 'service_id');
            $table->tinyInteger('publish')->nullable();
            $table->integer('order')->nullable();
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
        Schema::dropIfExists('tour_service_items');
    }
}
