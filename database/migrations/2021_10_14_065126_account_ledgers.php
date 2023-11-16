<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AccountLedgers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('account_ledgers', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->date('date');
            $table->integer('invoice_id')->nullable();
            $table->integer('account_id');
            $table->string('cheque_number', 70)->nullable();
            $table->text('description');
            $table->string('transaction_type', 50);
            $table->double('debit');
            $table->double('credit');
            $table->string('voucher_number');
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
        Schema::dropIfExists('account_ledgers');
    }
}
