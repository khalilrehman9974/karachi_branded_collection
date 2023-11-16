<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturnDetail extends Model
{
    use HasFactory;

    protected $table = 'purchase_return_detail';

    protected $fillable = ['product_id','category_id','brand_id','price','quantity','amount', 'purchase_return_master_id'];

    protected $guarded = ['id'];

}
