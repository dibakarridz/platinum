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
        Schema::create('queries', function (Blueprint $table) {
            $table->id();
            $table->string('prefix_quoteid',50)->nullable();
            $table->string('comes_website')->nullable();
            $table->string('full_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone',30)->nullable();
            $table->string('mobile',20)->nullable();
            $table->text('address')->nullable();
            $table->string('city',100)->nullable();
            $table->string('postcode',255)->nullable();
            $table->text('booked_comment')->nullable();
            $table->tinyInteger('status')->default(1)->comment('1= New Quote, 2 = Quoted, 3 = Forward, 4 = Booked');
            $table->tinyInteger('active')->default(1)->comment('0 = inactive, 1 = active');
            $table->timestamp('datetime')->nullable();
            $table->string('ip_address',50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('queries');
    }
};
