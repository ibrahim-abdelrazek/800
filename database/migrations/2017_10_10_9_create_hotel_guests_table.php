<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHotelGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hotel_guests', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('officer_name');
            $table->string('contact_number');
            $table->string('guest_room_number');
            $table->string('guest_first_name');
            $table->string('guest_last_name');
            $table->string('items');
            $table->integer('partner_id')->unsigned();
            $table->integer('user_id')->nullable();

            $table->foreign('partner_id')->references('id')->on('partners')->onDelete('cascade');


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
        Schema::dropIfExists('hotel_guests');
    }
}
