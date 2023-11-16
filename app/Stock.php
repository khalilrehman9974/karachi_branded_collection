<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $table = 'stock';

    protected $guarded = ['id'];

    protected $fillable = ['invoice_id', 'product_id', 'debit_quantity', 'credit_quantity', 'transaction_type'];

}
