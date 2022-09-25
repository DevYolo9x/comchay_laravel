<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTourBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tour_books', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Tour::class, 'tour_id');
            $table->string('fullname');
            $table->string('phone');
            $table->date('date');
            $table->text('people');
            $table->text('message')->nullable();
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
        Schema::dropIfExists('tour_books');
    }
}
