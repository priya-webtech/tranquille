<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('active',2)->default('Y');
            $table->string('firstname')->nullable();
            $table->string('lastname')->nullable();
            $table->string('profile')->nullable();
            $table->string('phone')->unique()->nullable();
            $table->date('dob')->nullable();
            $table->enum('type', ['User', 'Provider', 'Admin'])->comment('User or Provider')->nullable();
            $table->integer('otp')->nullable();
            $table->string('device_token',450)->nullable();
            $table->boolean('email_verified')->default(false);
            $table->boolean('phone_verified')->default(false);
            $table->boolean('is_notify')->default(false);
            $table->string('language')->nullable();
            $table->string('social_id',450)->nullable();
            $table->string('country',200)->nullable();
            $table->enum('socialtype', ['Google', 'Facebook'])->comment('Google Facebook')->nullable();
            $table->integer('profile_status')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
}
