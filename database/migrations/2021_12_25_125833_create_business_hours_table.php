<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBusinessHoursTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('business_hours', function (Blueprint $table) {
            $table->id();
            $table->string('active',5)->default('Y');
            $table->unsignedBigInteger('vendor_id')->index()->nullable();
            $table->string('timeMonStart',50)->nullable();
            $table->string('timeMonEnd',50)->nullable();
            $table->boolean('dayMondayStatus',5)->default(false);
            $table->string('timeTueStart',50)->nullable();
            $table->string('timeTueEnd',50)->nullable();
            $table->boolean('dayTuesdayStatus',5)->default(false);
            $table->string('timeWedStart',50)->nullable();
            $table->string('timeWedEnd',50)->nullable();
            $table->boolean('dayWednesdayStatus',5)->default(false);
            $table->string('timeThuStart',50)->nullable();
            $table->string('timeThuEnd',50)->nullable();
            $table->boolean('dayThursdayStatus',5)->default(false);
            $table->string('timeFriStart',50)->nullable();
            $table->string('timeFriEnd',50)->nullable();
            $table->boolean('dayFridayStatus',5)->default(false);
            $table->string('timeSatStart',50)->nullable();
            $table->string('timeSatEnd',50)->nullable();
            $table->boolean('daySaturdayStatus',5)->default(false);
            $table->string('timeSunStart',50)->nullable();
            $table->string('timeSunEnd',50)->nullable();
            $table->boolean('daySundayStatus',5)->default(false);
            $table->string('timeMonFriStart',50)->nullable();
            $table->string('timeMonFriEnd',50)->nullable();
            $table->boolean('dayMonFriStatus',5)->default(false);
            $table->bigInteger('created_by')->index()->nullable();
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
        Schema::dropIfExists('business_hours');
    }
}
