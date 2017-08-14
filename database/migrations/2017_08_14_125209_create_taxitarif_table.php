<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxiTarifTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxitarif', function (Blueprint $table) {
            $table->increments('id');
            $table->double('price_minimum');
            $table->double('min_hour')->nullable();
            $table->double('min_distance')->nullable();
            $table->double('price_per_hour')->nullable();
            $table->double('price_per_distance')->nullable();
            $table->integer('discard')->default(0);
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
        Schema::dropIfExists('taxitarif');
    }
}
