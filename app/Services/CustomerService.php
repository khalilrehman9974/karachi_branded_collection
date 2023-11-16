<?php


namespace App\Services;


use App\Customer;
use Carbon\Carbon;

class CustomerService
{
    const PER_PAGE = 10;
    const CUSTOMER_SAVED = 'Customer saved successfully';
    const CUSTOMER_UPDATED = 'Customer updated successfully';
    const CUSTOMER_DELETED = 'Customer is deleted successfully';
    const SOME_THING_WENT_WRONG = 'Oops!Something went wrong';

    protected $commonService;

    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }

    /*
     * Advance Search data on issuance records.
     * @queries: $queries
     * @return: object
     * */
    public function searchCustomer($request)
    {
        $customers = [];
        $query = Customer::get();
        if (!empty($request)) {
            if(!empty($request['param'])){
                $query = Customer::where('name', 'like', '%' . $request['param'] . '%')
                    ->orwhere('email', 'like', '%' . $request['param'] . '%')
                    ->orwhere('phone_no', 'like', '%' . $request['param'] . '%')
                    ->orwhere('mobile_no', 'like', '%' . $request['param'] . '%')
                    ->orwhere('whatsapp_no', 'like', '%' . $request['param'] . '%')
                    ->orwhere('city', 'like', '%' . $request['param'] . '%');
            }
            if (!empty($request) && $request['mobile_no'] != '') {
                $query = $query->where('mobile_no', $request['mobile_no']);
            }
            if (!empty($request) && $request['whatsapp_no'] != '') {
                $query = $query->where('whatsapp_no', $request['whatsapp_no']);
            }
            if (!empty($request) && $request['city'] != '') {
                $query = $query->where('city', 'like', '%' . $request['city'] . '%');
            }
            if (!empty($request['from_date']) && !empty($request['to_date'])) {
                $query = $query->whereBetween('created_at', [Carbon::parse($request['from_date'])->format('Y-m-d') . " 00:00:00", Carbon::parse($request['to_date'])->format('Y-m-d') . " 23:59:59"]);
            }
        }

        if(!empty($request['param'])){
            $customers = $query->get();
        }else{
            $customers = $query;
        }

        return $this->commonService->paginate($customers, Self::PER_PAGE);
    }

}
