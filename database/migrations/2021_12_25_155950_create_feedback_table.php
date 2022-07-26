<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFeedbackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('feedback', function (Blueprint $table) {
            $table->id();
            $table->string('active',5)->default('Y');
            $table->unsignedBigInteger('reviewby')->index()->nullable();
            $table->unsignedBigInteger('reviewto')->index()->nullable();
            $table->unsignedBigInteger('booking_id')->index()->nullable();
            $table->unsignedBigInteger('treatment_id')->index()->nullable();
            $table->tinyInteger('rating');
            $table->string('review',450)->nullable();
            $table->enum('type', ['Ambiance', 'Hygiene', 'Medewerkers','Overall'])->comment('Ambiance , Hygiene , Medewerkers, or Overall')->nullable();
            $table->softDeletes('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('reviewby')->references('id')->on('users');
            $table->foreign('reviewto')->references('id')->on('users');
            $table->foreign('booking_id')->references('id')->on('bookings');
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
        Schema::dropIfExists('feedback');
    }
}
