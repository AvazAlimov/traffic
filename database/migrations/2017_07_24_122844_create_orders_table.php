<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('user_type');
            $table->integer('user_id')->nullable();
            $table->integer('car_id');
            $table->integer('tarif_id');
            $table->string('point_A');
            $table->string('point_B');
            $table->string('address_A');
            $table->string('address_B');
            $table->double('unit');
            $table->tinyInteger('persons');
            $table->timestamp('start_time');
            $table->string('phone');
            $table->string('name');
            $table->double('sum');
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
        Schema::dropIfExists('orders');
    }
}
