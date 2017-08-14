<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaxiorderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('taxiorder', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('user_type');
            $table->integer('user_id')->nullable();
            $table->double('minute')->default(0);
            $table->double('distance');
            $table->string('point_A');
            $table->string('point_B');
            $table->string('address_A');
            $table->string('address_B');
            $table->timestamp('start_time');
            $table->string('phone');
            $table->string('name');
            $table->double('price');
            $table->tinyInteger('status')->default(0);
            $table->integer('operator_id')->nullable();
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
        Schema::dropIfExists('taxiorder');
    }
}
