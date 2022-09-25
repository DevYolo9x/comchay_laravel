<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBriefingCategoryRelationshipsTable extends Migration
{

    public function up()
    {
        Schema::create('briefing_category_relationships', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Briefing::class, 'module_id');
            $table->foreignIdFor(\App\Models\BriefingCategory::class, 'module_category_id');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('briefing_category_relationships');
    }
}
