<?php

namespace App\Http\Controllers;

use App\AccountLedger;
use App\Http\Requests\BRVStoreRequest;
use App\Http\Requests\CPvStoreRequest;
use App\Services\BankReceiptService;
use App\Services\CommonService;
use App\Services\PermissionService;
use App\Services\UploadFileService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class BankReceiptVouchersController extends Controller
{
    private $commonService;
    private $bankReceiptService;
    private $permissionService;

    public function __construct(CommonService $commonService, BankReceiptService $bankReceiptService,PermissionService $permissionService)
    {
        $this->commonService = $commonService;
        $this->bankReceiptService = $bankReceiptService;
        $this->permissionService = $permissionService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $brvs = $this->bankReceiptService->getBrvList(request()->all());
//        dd($brvs);
        $permission = $this->permissionService->getUserPermission(Auth::user()->id, '4');

        return view('vouchers.brv.index', compact('brvs', 'permission'));
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

        return view('vouchers.brv.create', compact('dropDownData', 'permission'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CPVStoreRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(BRVStoreRequest $request)
    {
        $maxVoucherNo = AccountLedger::max('id');
        $maxVoucherNo = $maxVoucherNo + 1;
        $debitData = $this->bankReceiptService->debitDataArray($request, $maxVoucherNo);
        $creditData = $this->bankReceiptService->creditDataArray($request, $maxVoucherNo);
        $id = isset($request['brvId']) ? $request['brvId'] : '';
        if($id){
            AccountLedger::where('voucher_number', $request['brvId'])->delete();
        }
        $insertDebit = $this->bankReceiptService->findUpdateOrCreate(AccountLedger::class, ['id'=>''], $debitData);
        $insertCredit = $this->bankReceiptService->findUpdateOrCreate(AccountLedger::class, ['id'=>''], $creditData);
        if($insertDebit && $insertCredit){
            $message = 'Bank Payment Voucher has been added';
        }else{
            return redirect('brv/list')->withMessage('Error', 'Something went wrong');
        }

        if($id){
            $message = 'Bank Payment Voucher has been updated';
        }
        Session::flash('message', $message);
        return redirect('brv/list');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brv = AccountLedger::find($id);
        $party = AccountLedger::where('credit','>',0)->where('voucher_number', $brv->voucher_number)->first();
        $permission = $this->permissionService->getUserPermission(Auth::user()->id, '4');
        $dropDownData = $this->commonService->vouchersDropDownData();

        return view('vouchers.brv.create', compact('brv', 'party', 'dropDownData', 'permission'));
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
            return response()->json(['status' => 'success', 'message' => "Voucher deleted successfuly"]);
        } else {
            return response()->json(['status' => 'fail', 'message' => 'Oops!Somethings went wrong, Record not deleted']);
        }
    }
}
