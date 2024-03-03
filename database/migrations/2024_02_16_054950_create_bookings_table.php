<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('query_id');
            $table->string('booking_pickupPoint')->nullable();
            $table->string('booking_postcode',20)->nullable();
            $table->timestamp('pick_datetime')->nullable();
            $table->bigInteger('noOf_passenger')->nullable();
            $table->string('booking_return')->nullable();
            $table->string('destination')->nullable();
            $table->string('destination_postcode',20)->nullable();
            $table->timestamp('returning_datetime')->nullable();
            $table->longText('journey_details')->nullable();
            $table->string('occasion')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0 = inactive, 1 = active');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('query_id')->references('id')->on('queries')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};
