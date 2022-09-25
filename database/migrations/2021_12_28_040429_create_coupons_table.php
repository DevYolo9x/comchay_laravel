<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCouponsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('migration');
        Schema::create('coupons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->text('description');
            $table->string('image');
            $table->string('type');
            $table->double('value');
            $table->date('expiry_date');
            $table->double('min_price');
            $table->double('max_price');
            $table->double('min_count');
            $table->double('max_count');
            $table->text('product_ids');
            $table->text('exclude_product_ids');
            $table->text('product_categories');
            $table->text('exclude_product_categories');
            $table->integer('limit');
            $table->integer('limit_user');
            $table->tinyInteger('publish');
            $table->string('meta_title');
            $table->text('meta_description');
            $table->integer('userid_created');
            $table->integer('userid_updated');
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
        Schema::dropIfExists('coupons');
    }
}
