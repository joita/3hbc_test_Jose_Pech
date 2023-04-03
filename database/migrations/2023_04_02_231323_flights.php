<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Flights extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('flights', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->enum('type', ['PASSENGER','FREIGHT']);
            $table->unsignedBigInteger('departure_id');
            $table->unsignedBigInteger('destination_id');
            $table->time('departure_time');
            $table->time('arrival_time');
            $table->unsignedBigInteger('airline_id');
            $table->foreign('airline_id')->references('id')->on('airlines');
            $table->foreign('departure_id')->references('id')->on('airports');
            $table->foreign('destination_id')->references('id')->on('airports');
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
        Schema::dropIfExists('flights');
    }
}
