<?php

namespace App\Http\Controllers;

use App\AccountLedger;
use App\Http\Requests\CRVStoreRequest;
use App\Services\CashReceiptService;
use App\Services\CommonService;
use App\Services\PermissionService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CashReceiptVouchersController extends Controller
{
    private $commonService;
    private $cashReceiptService;
    private $permissionService;

    public function __construct(CommonService $commonService, CashReceiptService $cashReceiptService,PermissionService $permissionService)
    {
        $this->commonService = $commonService;
        $this->cashReceiptService = $cashReceiptService;
        $this->permissionService = $permissionService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $crvs = $this->cashReceiptService->getCrvList();
        $permission = $this->permissionService->getUserPermission(Auth::user()->id, '4');

        return view('vouchers.crv.index', compact('crvs', 'permission'));
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

        return view('vouchers.crv.create', compact('dropDownData', 'permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CRVStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CRVStoreRequest $request)
    {
        $voucherNumber = AccountLedger::where('transaction_type', CommonService::CASH_RECEIPT_VOUCHER)->max('id');
        $creditData = $this->cashReceiptService->dataArrayCredit($request, $voucherNumber);
        $debitData = $this->cashReceiptService->dataArrayDebit($request, $voucherNumber);
        $id = isset($request['crvId']) ? $request['crvId'] : '';
        $insertDebitData = AccountLedger::create($debitData);
        $insertCreditData = AccountLedger::create($creditData);
        if($insertCreditData && $insertDebitData){
            $message = 'Cash Receipt Voucher has been added';
        }else{
            return redirect('crv/list')->withMessage('Error', 'Something went wrong');
        }
        Session::flash('message', $message);
        return redirect('crv/list');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $crv = AccountLedger::find($id);
        $permission = $this->permissionService->getUserPermission(Auth::user()->id, '4');
        $dropDownData = $this->commonService->vouchersDropDownData();

        return view('vouchers.crv.create', compact('crv', 'dropDownData', 'permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CRVStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function update(CRVStoreRequest $request)
    {
        $voucherNumber = $request['crvId'];
        AccountLedger::where('voucher_number', $request['crvId'])->delete();
        $creditData = $this->cashReceiptService->dataArrayCredit($request, $voucherNumber);
        $debitData = $this->cashReceiptService->dataArrayDebit($request, $voucherNumber);
        $insertDebitData = AccountLedger::create($debitData);
        $insertCreditData = AccountLedger::create($creditData);
        if($insertCreditData && $insertDebitData){
            $message = 'Cash Receipt Voucher updated successfully';
        }else{
            return redirect('crv/list')->withMessage('Error', 'Something went wrong');
        }
        Session::flash('message', $message);
        return redirect('crv/list');
    }

    /**
     * Remove the specified resource from storage.
     *
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
}
