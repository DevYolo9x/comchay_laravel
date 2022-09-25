<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourAttributeRelationshipsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_attribute_relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Tour::class, 'tour_id');
            $table->foreignIdFor(\App\Models\TourCategory::class, 'tour_category_id');
            $table->foreignIdFor(\App\Models\Attribute::class, 'attribute_id');
            $table->foreignIdFor(\App\Models\CategoryAttribute::class, 'attribute_category_id');
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
        Schema::dropIfExists('tour_attribute_relationships');
    }
}