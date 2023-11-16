<?php

namespace App\Http\Controllers;

use App\Services\AccountLedgerService;
use App\Services\CommonService;

class AccountsLedgerController extends Controller
{
    protected $commonService;
    protected $accountLedgerService;

    public function __construct(CommonService $commonService, AccountLedgerService $accountLedgerService)
    {
        $this->commonService = $commonService;
        $this->accountLedgerService = $accountLedgerService;
    }

    public function index(){
        $accounts = $this->commonService->vouchersDropDownData();
        $data = [];
        return view('reports.account_ledger', compact('accounts', 'data'));
    }

    public function view(){
        $params = request()->all();
        $accounts = $this->commonService->vouchersDropDownData();
        $data = $this->accountLedgerService->viewLedger(request()->all());
//        dd($data);

        return view('reports.account_ledger', compact('data', 'accounts', 'params'));
    }
}
