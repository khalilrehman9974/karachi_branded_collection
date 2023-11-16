<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseReturnMaster extends Model
{
    use HasFactory;

    protected $table = 'purchase_return_master';

    protected $fillable = ['date', 'party_id','brand_id', 'amount','quantity','remarks'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $guarded = ['id'];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function party(){
        return $this->belongsTo(Account::class, 'party_id', 'account_code');
    }
}
