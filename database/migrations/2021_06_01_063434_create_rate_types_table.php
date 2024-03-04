<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRateTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_types', function (Blueprint $table) {
            $table->id();
            $table->integer('hotel_id')->nullable();
            $table->string('name')->nullable();
            $table->string('short_description')->nullable();
            $table->string('cancellation_condition')->nullable();
            $table->string('is_refundable')->nullable();
            $table->string('deposit_percentage')->nullable();
            $table->integer('cancellation_days')->nullable();
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
        Schema::dropIfExists('rate_types');
    }
}
