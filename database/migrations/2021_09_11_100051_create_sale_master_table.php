<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleMasterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_master', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->date('date');
            $table->string('customer_id');
            $table->integer('brand_id');
            $table->double('amount');
            $table->double('quantity');
            $table->string('tracking_number', 250);
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
        Schema::dropIfExists('sale_master');
    }
}
