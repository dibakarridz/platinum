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
        Schema::create('quoteds', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('query_id');
            $table->json('prices')->nullable();
            $table->longText('quotation_details')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0 = inactive, 1 = active'); 
            $table->timestamp('datetime')->nullable();
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
        Schema::dropIfExists('quoteds');
    }
};
