<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReferralEarnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('referral_earns', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('referralby')->index()->nullable();
            $table->unsignedBigInteger('referralto')->index()->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone')->unique()->nullable();
            $table->string('referral_code')->nullable();
            $table->date('referral_date')->nullable();
            $table->double('amount', 8, 2)->default(0.00);
            $table->string('share_via')->nullable();
            $table->timestamps();
            $table->foreign('referralby')->references('id')->on('users');
            $table->foreign('referralto')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('referral_earns');
    }
}
