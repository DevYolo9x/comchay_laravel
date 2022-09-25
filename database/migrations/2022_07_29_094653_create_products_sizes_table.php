<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products_sizes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('title_color');
            $table->string('code')->nullable();
            $table->string('price')->nullable();
            $table->string('price_sale')->nullable();
            $table->tinyInteger('_stock_status')->nullable();
            $table->integer('_stock')->nullable();
            $table->tinyInteger('_outstock_status')->nullable();
            $table->foreignIdFor(\App\Models\Product::class, 'product_id');
            $table->foreignIdFor(\App\Models\products_color::class, 'color_id');
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
        Schema::dropIfExists('products_sizes');
    }
}
