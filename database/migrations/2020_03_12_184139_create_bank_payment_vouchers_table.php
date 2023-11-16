<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBankPaymentVouchersTable extends Migration
{

    protected $tableName = 'bank_payment_vouchers';


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
            $table->integer('bank_id')->unsigned();
            $table->integer('f_year_id')->unsigned();
            $table->string('bpv_no', 70);
            $table->string('cheque_no', 70);
            $table->string('account_no', 70);
            $table->string('paid_to', 100);
            $table->date('date')->nullable();
            $table->double('wht',10,2)->nullable();
            $table->text('description')->nullable();
            $table->double('amount', 10,2);
            $table->integer('created_by')->unsigned()->nullable();
            $table->integer('updated_by')->unsigned()->nullable();
            $table->timestamps();

            $table->foreign('bank_id')
                ->references('id')->on('banks')
                ->onDelete('cascade');

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
