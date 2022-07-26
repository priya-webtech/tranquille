<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('active',2)->default('Y');
            $table->string('plan_name')->nullable();
            $table->string('plan_type')->nullable();
            $table->double('amount', 8, 2)->nullable();
            $table->integer('days')->nullable();
            $table->text('description')->nullable();
            $table->boolean('portfolio')->default(false);
            $table->boolean('calendar')->default(false);
            $table->boolean('available')->default(false);
            $table->boolean('long_bio')->default(false);
            $table->boolean('profile_bg')->default(false);
            $table->boolean('performance')->default(false);
            $table->boolean('account_data')->default(false);
            $table->boolean('liability')->default(false);
            $table->boolean('dbs_option')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('subscriptions');
    }
}
