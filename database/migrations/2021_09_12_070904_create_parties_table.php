<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePartiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parties', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name', 70);
            $table->string('email', 30)->nullable();
            $table->string('phone_no', 30)->nullable();
            $table->string('mobile_no', 30);
            $table->string('whatsapp_no', 30)->nullable();
            $table->string('mailing_address', 250);
            $table->string('shipping_address', 250);
            $table->string('city');
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
        Schema::dropIfExists('parties');
    }
}
