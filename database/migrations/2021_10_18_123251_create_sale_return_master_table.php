<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleReturnMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_return_master', function (Blueprint $table) {
            $table->increments('id')->nullable();
            $table->date('date');
            $table->string('customer_id');
            $table->integer('brand_id');
            $table->double('amount');
            $table->double('quantity');
            $table->string('tracking_number', 250)->nullable();
            $table->text('remarks')->nullable();
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
        Schema::dropIfExists('sale_return_master');
    }
}
