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
        Schema::create('cashier_sale', function (Blueprint $table) {
            $table->id();
            $table->float("total_value");
            $table->unsignedBigInteger("id_pg_method");
            $table->foreign('id_pg_method')->references('id')->on('pg_method');
            $table->unsignedBigInteger("id_client");
            $table->foreign('id_client')->references('id')->on('client');
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
        Schema::dropIfExists('cashier_sale');
    }
};
