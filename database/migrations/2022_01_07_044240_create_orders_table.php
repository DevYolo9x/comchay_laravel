<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('customerid')->nullable();
            $table->string('fullname')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('address')->nullable();
            $table->integer('cityid')->nullable();
            $table->integer('districtid')->nullable();
            $table->text('note')->nullable();
            $table->string('payment')->nullable();
            $table->text('cart')->nullable();
            $table->text('coupon')->nullable();
            $table->double('total_price')->nullable();
            $table->integer('total_item')->nullable();
            $table->double('total_price_coupon')->nullable();
            $table->double('total_price_ship')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
