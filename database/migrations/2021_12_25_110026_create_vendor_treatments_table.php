<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_treatments', function (Blueprint $table) {
            $table->id();
            $table->string('active',5)->default('Y');
            $table->unsignedBigInteger('vendor_id')->index()->nullable();
            $table->unsignedBigInteger('treatment_id')->index()->nullable();
            $table->string('description',450)->nullable();
            $table->double('price', 8, 2)->default(0.00);
            $table->float('discount', 4, 2)->nullable();
            $table->integer('no_of_person')->default(1);
            $table->timestamps();
            $table->foreign('vendor_id')->references('id')->on('users');
            $table->foreign('treatment_id')->references('id')->on('treatments');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vendor_treatments');
    }
}
