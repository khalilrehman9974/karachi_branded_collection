<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Http\Requests\StoreCustomerRequest;
use App\Services\CommonService;
use App\Services\CustomerService;

class CustomerController extends Controller
{
    protected $customerService;
    protected $commonService;

    public function __construct(CustomerService $customerService, CommonService $commonService)
    {
        $this->customerService = $customerService;
        $this->commonService = $commonService;
    }

    /*
     * Show page of list of customers.
     * */
    public function index(){
        $request = request()->all();
        $customers = $this->customerService->searchCustomer($request);
        return view('customers.index', compact('customers', 'request'));
    }

    /*
     * Show page of create customer.
     * */
    public function create(){
        return view('customers.create');
    }

    /*
     * Save customer into db.
     * @param: @request
     * */
    public function store(StoreCustomerRequest $request){
        $request = $request->except('_token', 'customerId');
        $this->commonService->findUpdateOrCreate(Customer::class, ['id' => ''], $request);

        return redirect('customer/customers-list')->with('message', CustomerService::CUSTOMER_SAVED);
    }

    /*
     * Show edit page.
     * */
    public function edit($id){
        $customer = Customer::find($id);
        if(empty($customer)){
           abort(404);
        }
        return view('customers.create', compact('customer'));
    }

    /*
     * update existing resource.
     * @param: $data
     * */
    public function update(StoreCustomerRequest $request){
        $request = $request->except('_token','customerId');
        $this->commonService->findUpdateOrCreate(Customer::class, ['id' => request('customerId')], $request);
        return redirect('customer/customers-list')->with('message', CustomerService::CUSTOMER_UPDATED);
    }

    /*
     * Delete existing resource.
     * @param: request()->id
     * */
    public function delete(){
        $deleted = Customer::where('id', request()->id)->delete();
        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => CustomerService::CUSTOMER_DELETED]);
        } else {
            return response()->json(['status' => 'fail', 'message' => CustomerService::SOME_THING_WENT_WRONG]);
        }
    }

    /*
     * View Customer detail.
     * @param: $id
     * */
    public function view($id){
        $customer = Customer::find($id);
        if(empty($customer)){
            abort(404);
        }

        return view('customers.view', compact('customer'));
    }
}
