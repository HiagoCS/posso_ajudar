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
        Schema::create('update_stock_out', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_stock_out');
            $table->foreign('id_stock_out')->references('id')->on('products_stock_out');
            $table->string("name");
            $table->string("value");
            $table->string("cost");
            $table->string("quantity");
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
        Schema::dropIfExists('update_stock_out');
    }
};
