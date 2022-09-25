<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourServiceRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_service_relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Tour::class, 'tour_id');
            $table->foreignIdFor(\App\Models\TourService::class, 'tour_service_id');
            $table->foreignIdFor(\App\Models\TourServiceItem::class, 'tour_service_item_id');
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
        Schema::dropIfExists('tour_service_relationships');
    }
}
