<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOffersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->integer('hotel_id');
            $table->string('name');
            $table->string('image');
            $table->text('description');
            $table->date('valid_from');
            $table->date('valid_to');
            $table->string('discount_percentage');
            $table->string('exclusive_days');
            $table->text('room_list');
            $table->string('days_of_week');
            $table->string('min_no_of_adults');
            $table->string('max_no_of_adults');
            $table->string('min_no_of_child');
            $table->string('max_no_of_child');
            $table->string('min_days_in_advance');
            $table->string('max_days_in_advance');
            $table->string('mobile_offer');
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
        Schema::dropIfExists('offers');
    }
}
