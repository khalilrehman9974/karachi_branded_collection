<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseMaster extends Model
{
    use HasFactory;

    protected $table = 'purchase_master';

    protected $fillable = ['date', 'party_id','brand_id'];

    protected $hidden = ['created_at', 'updated_at'];

    protected $guarded = ['id'];

    public function brand(){
        return $this->belongsTo(Brand::class);
    }

    public function party(){
        return $this->belongsTo(Account::class, 'party_id', 'account_code');
    }
}
