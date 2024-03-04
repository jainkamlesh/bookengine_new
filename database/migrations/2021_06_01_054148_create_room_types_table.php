<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->integer('hotel_id')->nullable();
            $table->text('short_description')->nullable();
            $table->string('base_adults')->nullable();
            $table->string('max_adults')->nullable();
            $table->string('max_child')->nullable();
            $table->string('size')->nullable();
            $table->string('size_unit')->nullable();
            $table->string('bed_type')->nullable();
            $table->text('room_facilities')->nullable();
            $table->text('room_image')->nullable();
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
        Schema::dropIfExists('room_types');
    }
}
