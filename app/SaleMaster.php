<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleMaster extends Model
{
    use HasFactory;

    protected $table = 'sale_master';

    protected $fillable = ['date', 'customer_id','brand_id','amount','quantity','tracking_number','remarks'];

    protected $guarded = ['id'];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function customer(){
        return $this->belongsTo(Account::class, 'customer_id', 'account_code');
    }
}
