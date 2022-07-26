<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorDemosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_demos', function (Blueprint $table) {
            $table->id();
            $table->string('active',5)->default('Y');
            $table->unsignedBigInteger('vendor_id')->index()->nullable();
            $table->string('demo_image',450)->nullable();
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->softDeletes('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('vendor_id')->references('id')->on('users');
            $table->foreign('created_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_demos');
    }
}
