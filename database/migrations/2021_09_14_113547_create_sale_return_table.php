<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleReturnTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_return', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('product_id');
            $table->integer('category_id');
            $table->integer('brand_id');
            $table->integer('bill_number');
            $table->double('price');
            $table->integer('quantity');
            $table->string('tracking_number', 250);
            $table->integer('sale_master_id');
            $table->text('remarks');
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
        Schema::dropIfExists('sale_return');
    }
}
