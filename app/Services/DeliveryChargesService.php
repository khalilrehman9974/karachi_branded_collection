<?php


namespace App\Services;


use App\Customer;
use App\DeliveryChargesPrice;
use Carbon\Carbon;

class DeliveryChargesService
{

    const PER_PAGE = 10;
    const DC_SAVED = 'Delivery charges saved successfully';
    const DC_UPDATED = 'Delivery charges updated successfully';
    const DC_DELETED = 'Delivery charges is deleted successfully';
    const SOME_THING_WENT_WRONG = 'Oops!Something went wrong';

    protected $commonService;

    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }

    /*
     * Get list of delivery charges.
     * */
    public function deliveryChargesData(){
        return DeliveryChargesPrice::leftjoin('zones','zones.id', '=','delivery_charges_price.zone_id')
            ->leftjoin('shipment_types','shipment_types.id', '=','delivery_charges_price.shipment_type_id')
            ->select('delivery_charges_price.fuel_percentage','delivery_charges_price.gst_percentage','zones.name as zoneName','shipment_types.name as shipmentType')
            ->paginate(Self::PER_PAGE);
    }

}
