<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCashReceiptVouchersTable extends Migration
{

    protected $tableName = 'cash_receipt_vouchers';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->Increments('id');
            $table->integer('project_id')->unsigned();
            $table->string('crv_no', 50);
            $table->integer('f_year_id')->unsigned();
            $table->string('received_from', 70);
            $table->string('account', 100);
            $table->text('description')->nullable();
            $table->double('wht', 10,2);
            $table->date('date');
            $table->double('amount', 10,2);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
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
        Schema::dropIfExists($this->tableName);
    }
}
