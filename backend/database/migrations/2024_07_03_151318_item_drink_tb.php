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
        Schema::create('item_drink_tb', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_bar_menu');
            $table->unsignedBigInteger('id_bar_stuff');
            $table->string('item_qnt_used');
            $table->foreign('id_bar_menu')->references('id')->on('bar_menu');
            $table->foreign('id_bar_stuff')->references('id')->on('bar_stuff');
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
        Schema::dropIfExists('item_drink_tb');
    }
};
