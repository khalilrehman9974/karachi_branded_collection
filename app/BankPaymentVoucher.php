<?php

namespace App;

use App\Bank;
use Illuminate\Database\Eloquent\Model;

class BankPaymentVoucher extends Model
{
    const PER_PAGE = 10;
    const FILE_PATH = 'uploads/vouchers/bpv/';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'project_id', 'bank_id', 'f_year_id','bpv_no','cheque_no','account_no','paid_to','date','wht','description','amount','created_by','updated_by'
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'id', 'bank_id');
    }
}
