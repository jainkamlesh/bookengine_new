<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRateRestrictionMastersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rate_restriction_masters', function (Blueprint $table) {
            $table->id();
            $table->integer('property_id');
            $table->integer('room_type_id');
            $table->integer('rate_plan_id');
            $table->date('date');
            $table->float('base_amount');
            $table->float('extra_adult_1_amount');
            $table->float('extra_adult_2_amount');
            $table->float('extra_adult_3_amount');
            $table->float('extra_adult_4_amount');
            $table->float('child_age_1_rate');
            $table->float('child_age_2_rate');
            $table->float('child_age_3_rate');
            $table->float('child_age_4_rate');
            $table->float('single_amount');
            $table->tinyInteger('closed')->default('1');
            $table->integer('minstay');
            $table->integer('maxstay');
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
        Schema::dropIfExists('rate_restriction_masters');
    }
}
