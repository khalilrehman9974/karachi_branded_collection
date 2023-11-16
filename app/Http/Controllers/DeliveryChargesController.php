<?php

namespace App\Http\Controllers;

use App\DeliveryChargesPrice;
use App\Http\Requests\StoreDeliveryChargesRequest;
use App\Services\CommonService;
use App\Services\DeliveryChargesService;
use App\ShipmentType;
use App\Zone;

class DeliveryChargesController extends Controller
{
    protected $deliveryChargesService;
    protected $commonService;

    public function __construct(DeliveryChargesService $deliveryChargesService, CommonService $commonService)
    {
        $this->deliveryChargesService = $deliveryChargesService;
        $this->commonService = $commonService;
    }

    /*
     * Show page of list of delivery charges.
     * */
    public function index(){
        $request = request()->all();
        $deliveryCharges = $this->deliveryChargesService->deliveryChargesData();
        return view('delivery-charges.index', compact('deliveryCharges', 'request'));
    }

    /*
     * Show page of create delivery charges.
     * */
    public function create(){
        $shipmentTypes = ShipmentType::pluck('name','id');
        $zones = Zone::pluck('name','id');

        return view('delivery-charges.create', compact( 'shipmentTypes', 'zones'));
    }

    /*
     * Save delivery charges into db.
     * @param: @request
     * */
    public function store(StoreDeliveryChargesRequest $request){
        $request = $request->except('_token', 'deliveryChargesId');
        $this->commonService->findUpdateOrCreate(DeliveryChargesPrice::class, ['id' => ''], $request);

        return redirect('delivery-charges/dc-list')->with('message', DeliveryChargesService::DC_SAVED);
    }

    /*
     * Show edit page.
     * */
    public function edit($id){
        $deliveryCharges = DeliveryChargesPrice::find($id);
        if(empty($deliveryCharges)){
            abort(404);
        }
        return view('delivery-charges.create', compact('deliveryCharges'));
    }

    /*
     * update existing resource.
     * @param: $data
     * */
    public function update(StoreDeliveryChargesRequest $request){
        $request = $request->except('_token','deliveryChargesId');
        $this->commonService->findUpdateOrCreate(DeliveryChargesPrice::class, ['id' => request('deliveryChargesId')], $request);
        return redirect('delivery-charges/dc-list')->with('message', DeliveryChargesService::DC_UPDATED);
    }

    /*
     * Delete existing resource.
     * @param: request()->id
     * */
    public function delete(){
        $deleted = DeliveryChargesPrice::where('id', request()->id)->delete();
        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => DeliveryChargesService::DC_DELETED]);
        } else {
            return response()->json(['status' => 'fail', 'message' => DeliveryChargesService::SOME_THING_WENT_WRONG]);
        }
    }

    /*
     * View Delivery charges detail.
     * @param: $id
     * */
    public function view($id){
        $deliveryCharges = DeliveryChargesPrice::find($id);
        if(empty($deliveryCharges)){
            abort(404);
        }

        return view('delivery-charges.view', compact('deliveryCharges'));
    }
}
