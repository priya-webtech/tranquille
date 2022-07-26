<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVendorTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vendor_teams', function (Blueprint $table) {
            $table->id();
            $table->string('active',5)->default('Y');
            $table->unsignedBigInteger('vendor_id')->index()->nullable();
            $table->string('employee_name')->nullable();
            $table->string('designation')->nullable();
            $table->string('skills')->nullable();
            $table->string('profile_pic')->nullable();
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
        Schema::dropIfExists('vendor_teams');
    }
}
