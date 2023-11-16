<?php

namespace App;

use App\Services\DeliveryChargesService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryChargesPrice extends Model
{
    use HasFactory;

    protected $table = 'delivery_charges_price';

    protected $fillable = ['shipment_type_id', 'zone_id','fuel_percentage','gst_percentage','additional_kg_charges'];

    protected $guarded = ['id'];

}
