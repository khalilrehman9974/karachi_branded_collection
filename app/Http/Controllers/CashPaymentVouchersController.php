<?php

namespace App\Http\Controllers;

use App\AccountLedger;
use App\Http\Requests\CPvStoreRequest;
use App\Http\Requests\CRVStoreRequest;
use App\Services\CashPaymentService;
use App\Services\CommonService;
use App\Services\PermissionService;
use App\Services\UploadFileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CashPaymentVouchersController extends Controller
{
    private $commonService;
    private $cashPaymentService;
    private $permissionService;

    public function __construct(CommonService $commonService, CashPaymentService $cashPaymentService,PermissionService $permissionService)
    {
        $this->commonService = $commonService;
        $this->cashPaymentService = $cashPaymentService;
        $this->permissionService = $permissionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cpvs = $this->cashPaymentService->getCpvList();
        $permission = $this->permissionService->getUserPermission(Auth::user()->id, '4');

        return view('vouchers.cpv.index', compact('cpvs', 'permission'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dropDownData = $this->commonService->vouchersDropDownData();
        $permission = $this->permissionService->getUserPermission(Auth::user()->id, '4');

        return view('vouchers.cpv.create', compact('dropDownData', 'permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CPvStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CPvStoreRequest $request)
    {
        $voucherNumber = AccountLedger::where('transaction_type', CommonService::CASH_PAYMENT_VOUCHER)->max('id');
        $creditData = $this->cashPaymentService->dataArrayCredit($request, $voucherNumber);
        $debitData = $this->cashPaymentService->dataArrayDebit($request, $voucherNumber);
        $insertDebitData = AccountLedger::create($debitData);
        $insertCreditData = AccountLedger::create($creditData);
        if($insertDebitData && $insertCreditData){
            $message = 'Cash Payment Voucher has been added';
        }else{
            return redirect('cpv/list')->withMessage('Error', 'Something went wrong');
        }
        Session::flash('message', $message);
        return redirect('cpv/list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cpv = AccountLedger::find($id);
        $permission = $this->permissionService->getUserPermission(Auth::user()->id, '4');
        $dropDownData = $this->commonService->vouchersDropDownData();

        return view('vouchers.cpv.create', compact('cpv', 'dropDownData', 'permission'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $deleted = AccountLedger::destroy(request()->id);
        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => 'Voucher is delete']);
        } else {
            return response()->json(['status' => 'fail', 'message' => 'Something is went wrong']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CPvStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(CPvStoreRequest $request)
    {
        $voucherNumber = $request['cpvId'];
        AccountLedger::where('voucher_number', $request['cpvId'])->delete();
        $creditData = $this->cashPaymentService->dataArrayCredit($request, $voucherNumber);
        $debitData = $this->cashPaymentService->dataArrayDebit($request, $voucherNumber);
        $insertDebitData = AccountLedger::create($debitData);
        $insertCreditData = AccountLedger::create($creditData);
        if($insertCreditData && $insertDebitData){
            $message = 'Cash Payment Voucher updated successfully';
        }else{
            return redirect('cpv/list')->with('error', 'Something went wrong');
        }

        Session::flash('message', $message);
        return redirect('cpv/list');
    }
}
