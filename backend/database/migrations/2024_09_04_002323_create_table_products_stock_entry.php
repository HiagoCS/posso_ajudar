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
        Schema::create('products_stock_entry', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("id_product");
            $table->foreign('id_product')->references('id')->on('products');
            $table->integer("qunt_toAdd");
            $table->date('dt_entry');
            $table->unsignedBigInteger("id_vendor")->nullable();
            $table->foreign('id_vendor')->references('id')->on('vendor');
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
        Schema::dropIfExists('products_stock_entry');
    }
};
