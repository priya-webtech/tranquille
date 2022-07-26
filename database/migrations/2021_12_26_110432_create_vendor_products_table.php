<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_products', function (Blueprint $table) {
            $table->id();
            $table->string('active',5)->default('Y');
            $table->unsignedBigInteger('vendor_id')->index()->nullable();
            $table->unsignedBigInteger('productbrand_id')->index()->nullable();
            $table->timestamps();
            $table->foreign('productbrand_id')->references('id')->on('product_brands');
            $table->foreign('vendor_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_products');
    }
}
