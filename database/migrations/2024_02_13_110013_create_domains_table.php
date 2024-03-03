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
        Schema::create('domains', function (Blueprint $table) {
            $table->id();
            $table->string('unique_id')->unique();
            $table->string('domain_name')->nullable();
            $table->string('domain')->nullable();
            $table->string('reply_email')->nullable();
            $table->string('protocol')->nullable();
            $table->string('smtp_host')->nullable();
            $table->integer('smtp_port')->nullable();
            $table->string('smtp_username')->nullable();
            $table->string('smtp_password')->nullable();
            $table->string('encryption')->nullable();
            $table->string('email_title')->nullable();
            $table->longText('template')->nullable();
            $table->tinyInteger('status')->default(1)->comment('0 = inactive, 1 = active');            
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
        Schema::dropIfExists('domains');
    }
};
