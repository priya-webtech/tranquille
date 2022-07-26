<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('treatments', function (Blueprint $table) {
            $table->id();
            $table->string('active',5)->default('Y');
            $table->unsignedBigInteger('service_id')->index()->nullable();
            $table->string('treatment_name',50)->nullable();
            $table->string('treatment_image',50)->nullable();
            $table->string('small_image',50)->nullable();
            $table->integer('rank')->nullable();
            $table->timestamps();
            $table->foreign('service_id')->references('id')->on('services');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('treatments');
    }
}
