<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecentlyViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recently_view', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('vendor_id')->index()->nullable();
            $table->unsignedBigInteger('user_id')->index()->nullable();
            $table->string('guest_ip')->nullable();
            $table->timestamp('view_time');
            $table->foreign('vendor_id')->references('id')->on('users');
            $table->foreign('user_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recently_view');
    }
}
