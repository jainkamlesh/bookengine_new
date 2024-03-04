<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatePlansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_plans', function (Blueprint $table) {
            /*$table->id();
            $table->integer('hotel_id');
            $table->string('name');
            $table->integer('room_type_id');
            $table->integer('rate_type_id');
            $table->string('adult_base_rate');
            $table->string('second_extra_adult_rate');
            $table->string('third_extra_adult_rate');
            $table->string('fourth_extra_adult_rate');
            $table->text('child_age_rate');
            $table->string('min_nights');
            $table->string('max_nights');
            $table->string('single_stay');
            $table->timestamps();*/

            $table->id();
            $table->integer('hotel_id');
            $table->string('name');
            $table->integer('room_type_id');
            $table->integer('rate_type_id');
            $table->double('room_price', 8, 2);
            $table->double('child_age1_rate', 8, 2);
            $table->double('child_age2_rate', 8, 2);
            $table->double('child_age3_rate', 8, 2);
            $table->double('ext_adult1_rate', 8, 2);
            $table->double('ext_adult2_rate', 8, 2);
            $table->double('ext_adult3_rate', 8, 2);
            $table->double('ext_adult3_rate', 8, 2);
            $table->double('ext_adult4_rate', 8, 2);
            $table->string('min_nights');
            $table->string('max_nights');
            $table->string('single_stay');
            $table->double('single_price', 8, 2);
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
        Schema::dropIfExists('rate_plans');
    }
}
