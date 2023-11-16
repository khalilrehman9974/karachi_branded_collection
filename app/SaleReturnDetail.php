<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleReturnDetail extends Model
{
    use HasFactory;

    protected $table = 'sale_return_detail';

    protected $fillable = ['product_id','price','quantity', 'amount','sale_return_master_id'];

    protected $guarded = ['id'];
}
