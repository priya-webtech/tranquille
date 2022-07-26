<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_details', function (Blueprint $table) {
            $table->id();
            $table->string('active',5)->default('Y');
            $table->unsignedBigInteger('vendor_id')->index()->nullable();
            $table->string('firm_name',250)->nullable();
            $table->string('about_us',450)->nullable();
            $table->string('service_type',250)->nullable();
            $table->string('website',250)->nullable();
            $table->string('referral_code',250)->unique()->nullable();
            $table->string('why_you',500)->nullable();
            $table->string('vatnumber', 100)->nullable();
            $table->string('latitude', 50)->nullable();
            $table->string('longitude', 50)->nullable();
            $table->string('country', 50)->nullable();
            $table->string('logo',250)->nullable();
            $table->softDeletes('deleted_at')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('vendor_details');
    }
}
