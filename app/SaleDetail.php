<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;

    protected $table = 'sale_detail';

    protected $fillable = ['product_id','price','quantity', 'amount','sale_master_id'];

    protected $guarded = ['id'];
}
