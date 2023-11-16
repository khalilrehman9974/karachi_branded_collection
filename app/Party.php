<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Party extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone_no', 'mobile_no', 'whatsapp_no', 'mailing_address', 'shipping_address', 'city'];

    protected $guarded = ['id'];
}
