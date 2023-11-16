<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name', 70);
            $table->string('email', 70)->nullable();
            $table->string('phone_no', 70)->nullable();
            $table->string('mobile_no', 70);
            $table->string('whatsapp_no', 70)->nullable();
            $table->string('mailing_address', 250);
            $table->string('shipping_address', 250);
            $table->string('city', 70);
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
        Schema::dropIfExists('customers');
    }
}
