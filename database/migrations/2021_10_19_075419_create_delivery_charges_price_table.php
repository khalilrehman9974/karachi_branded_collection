<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeliveryChargesPriceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_charges_price', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('shipment_type_id');
            $table->integer('zone_id');
            $table->integer('fuel_percentage');
            $table->integer('gst_percentage');
            $table->integer('additional_kg_charges');
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
        Schema::dropIfExists('delivery_charges_price');
    }
}
