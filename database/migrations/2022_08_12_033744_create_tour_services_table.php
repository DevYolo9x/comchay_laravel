<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_services', function (Blueprint $table) {
            $table->id();
            $table->string('alanguage');
            $table->string('title');
            $table->string('slug');
            $table->tinyInteger('publish')->nullable();
            $table->tinyInteger('type')->nullable();
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
        Schema::dropIfExists('tour_services');
    }
}