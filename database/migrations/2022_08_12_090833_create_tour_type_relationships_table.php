<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourTypeRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_type_relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Tour::class, 'tour_id');
            $table->foreignIdFor(\App\Models\TourType::class, 'tour_type_id');
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
        Schema::dropIfExists('tour_type_relationships');
    }
}
