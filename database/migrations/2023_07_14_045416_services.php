<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Services extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('name_it')->nullable();
            $table->string('name_fr')->nullable();
            $table->string('name_es')->nullable();
            $table->string('name_de')->nullable();
            $table->integer('hotel_id')->nullable();
            $table->text('short_description')->nullable();
            $table->text('short_description_it')->nullable();
            $table->text('short_description_fr')->nullable();
            $table->text('short_description_es')->nullable();
            $table->text('short_description_de')->nullable();
            // $table->text('long_description')->nullable();
            // $table->text('long_description_it')->nullable();
            // $table->text('long_description_fr')->nullable();
            // $table->text('long_description_es')->nullable();
            // $table->text('long_description_de')->nullable();
            $table->string('max_quantity')->nullable();
            $table->string('price')->nullable();
            $table->string('tax')->nullable();
            $table->text('images')->nullable();
            $table->integer('display_order')->nullable();
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
        Schema::dropIfExists('services');
    }
}
