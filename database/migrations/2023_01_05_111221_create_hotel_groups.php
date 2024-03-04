<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelGroups extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_groups', function (Blueprint $table) {
            $table->id();
			$table->text('backgroundimage');
			$table->string('businessname');
			$table->string('phone');
			$table->string('email');
			$table->longtext('customcss');
			$table->text('groupids');
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
        Schema::dropIfExists('hotel_groups');
    }
}
