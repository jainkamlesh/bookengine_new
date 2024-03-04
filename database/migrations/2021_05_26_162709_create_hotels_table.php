<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHotelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotels', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('country');
            $table->string('mobile');
            $table->string('postal_code');
            $table->string('latitude');
            $table->string('longtiude');
            $table->string('contact_name');
            $table->string('contact_email');
            $table->string('username');
            $table->string('password');
            $table->string('slug');
            $table->string('website_url');
            $table->string('reservation_email');
            $table->string('deposit_percentage');
            $table->text('child_age');
            $table->string('check_in');
            $table->string('check_out');
            $table->longtext('policy');
            $table->longtext('cancellation_policy');
            $table->longtext('parking_info');
            $table->longtext('wifi_info');
            $table->longtext('childress_policy');
            $table->longtext('other_info');
            $table->string('banner_image');
            $table->string('google');
            $table->longtext('custom_css');
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
        Schema::dropIfExists('hotels');
    }
}
