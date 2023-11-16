<?php

namespace App\Http\Controllers;

use App\AccountLedger;
use App\BankReceiptVoucher;
use App\Http\Requests\BPVStoreRequest;
use App\Http\Requests\CPvStoreRequest;
use App\Services\BankPaymentService;
use App\Services\CommonService;
use App\Services\MenuService;
use App\Services\PermissionService;
use App\Services\UploadFileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BankPaymentVouchersController extends Controller
{
    private $commonService;
    private $bankPaymentService;
    private $permissionService;

    public function __construct(CommonService $commonService, BankPaymentService $bankPaymentService,PermissionService $permissionService)
    {
        $this->commonService = $commonService;
        $this->bankPaymentService = $bankPaymentService;
        $this->permissionService = $permissionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $bpvs = $this->bankPaymentService->getBpvList();
        $permission = $this->permissionService->getUserPermission(Auth::user()->id, '4');

        return view('vouchers.bpv.index', compact('bpvs', 'permission'));
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

        return view('vouchers.bpv.create', compact('dropDownData', 'permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CPVStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BPVStoreRequest $request)
    {
        $maxVoucherNo = AccountLedger::max('id');
        $maxVoucherNo = $maxVoucherNo + 1;
        $debitData = $this->bankPaymentService->debitDataArray($request, $maxVoucherNo);
        $creditData = $this->bankPaymentService->creditDataArray($request, $maxVoucherNo);
        $id = isset($request['bpvId']) ? $request['bpvId'] : '';
        if($id){
            AccountLedger::where('voucher_number', $request['bpvId'])->delete();
        }
        $insertDebit = $this->bankPaymentService->findUpdateOrCreate(AccountLedger::class, ['id'=>''], $debitData);
        $insertCredit = $this->bankPaymentService->findUpdateOrCreate(AccountLedger::class, ['id'=>''], $creditData);
        if($insertDebit && $insertCredit){
            $message = 'Bank Payment Voucher has been added';
        }else{
            return redirect('bpv/list')->withMessage('Error', 'Something went wrong');
        }

        if($id){
            $message = 'Bank Payment Voucher has been updated';
        }
        Session::flash('message', $message);
        return redirect('bpv/list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bpv = AccountLedger::find($id);
        $party = AccountLedger::where('debit','>',0)->where('voucher_number', $bpv->voucher_number)->first();
        $permission = $this->permissionService->getUserPermission(Auth::user()->id, '4');
        $dropDownData = $this->commonService->vouchersDropDownData();

        return view('vouchers.bpv.create', compact('bpv', 'party', 'dropDownData', 'permission'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $deleted = AccountLedger::where('voucher_number',request()->id)->delete();
        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => "Voucher delete successfuly"]);
        } else {
            return response()->json(['status' => 'fail', 'message' => 'Oops!Somethings went wrong, Record not deleted']);
        }
    }
}
