<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->string('active',5)->default('Y');
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->unsignedBigInteger('vendor_id')->index()->nullable();
            $table->unsignedBigInteger('employee_id')->index()->nullable();
            $table->unsignedBigInteger('service_id')->index()->nullable();
            $table->unsignedBigInteger('treatment_id')->index()->nullable();
            $table->unsignedBigInteger('address_id')->index()->nullable();
            $table->date('booking_date')->nullable();
            $table->time('booking_time')->nullable();
            $table->string('orderid')->unique()->nullable();
            $table->dateTime('start_time')->nullable();
            $table->dateTime('expct_end_time')->nullable();
            $table->dateTime('end_time')->nullable();
            $table->double('expct_amount', 8, 2)->default(0.00);
            $table->double('full_amount', 8, 2)->default(0.00);
            $table->double('discount_amount', 8, 2)->default(0.00);
            $table->double('final_amount', 8, 2)->default(0.00);
            $table->boolean('canceled')->default(false);
            $table->tinyText('canceled_reson')->nullable();
            $table->string('user_name',250)->nullable();
            $table->string('address',250)->nullable();
            $table->string('latitude', 50)->nullable();
            $table->string('longitude', 50)->nullable();
            $table->unsignedBigInteger('status_id')->index()->nullable();
            $table->unsignedBigInteger('created_by')->index()->nullable();
            $table->unsignedBigInteger('updated_by')->index()->nullable();
            $table->unsignedBigInteger('deleted_by')->index()->nullable();
            $table->softDeletes('deleted_at')->nullable();
            $table->timestamps();
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('vendor_id')->references('id')->on('users');
            $table->foreign('service_id')->references('id')->on('services');
            $table->foreign('employee_id')->references('id')->on('vendor_teams');
            $table->foreign('treatment_id')->references('id')->on('treatments');
            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('created_by')->references('id')->on('users');
            $table->foreign('updated_by')->references('id')->on('users');
            $table->foreign('deleted_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
}
