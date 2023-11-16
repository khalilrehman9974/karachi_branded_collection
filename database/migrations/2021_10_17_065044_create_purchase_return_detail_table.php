<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePurchaseReturnDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchase_return_detail', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->integer('product_id');
            $table->double('price');
            $table->integer('quantity');
            $table->double('amount');
            $table->integer('purchase_return_master_id');
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
        Schema::dropIfExists('purchase_return_detail');
    }
}
