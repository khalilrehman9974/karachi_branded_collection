<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashPaymentVoucher extends Model
{

    const PER_PAGE = 10;

    protected $guarded = ['id'];

    public function party()
    {
        return $this->hasOne(Project::class, 'id', 'project_id');
    }
}
