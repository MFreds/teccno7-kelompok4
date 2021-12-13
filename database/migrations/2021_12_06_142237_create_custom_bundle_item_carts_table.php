<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomBundleItemCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('custom_bundle_item_carts', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');

            $table->unsignedBigInteger('custom_bundle_cart_id');
            $table->foreign('custom_bundle_cart_id')->references('id')->on('custom_bundle_carts');

            $table->unsignedBigInteger('item_id');
            $table->foreign('item_id')->references('id')->on('items');

            $table->unsignedBigInteger('amount');
            $table->unsignedBigInteger('total_price');

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
        Schema::dropIfExists('custom_bundle_item_carts');
    }
}
