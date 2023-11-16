<?php

namespace App\Http\Controllers;

use App\Account;
use App\AccountType;
use App\Http\Requests\StoreAccountRequest;
use App\Services\AccountService;
use App\Services\CommonService;

class AccountsController extends Controller
{
    protected $accountService;
    protected $commonService;

    public function __construct(AccountService $accountService, CommonService $commonService)
    {
        $this->accountService = $accountService;
        $this->commonService = $commonService;
    }

    /*
     * Show page of list of accounts.
     * */
    public function index(){
        $request = request()->all();
        $accounts = $this->accountService->searchAccount($request);
        return view('accounts.index', compact('accounts', 'request'));
    }

    /*
     * Show page of create account.
     * */
    public function create(){
        $accountTypes = AccountType::pluck('name', 'alias');
        return view('accounts.create', compact('accountTypes'));
    }

    /*
     * Save account into db.
     * @param: @request
     * */
    public function store(StoreAccountRequest $request){
        $request = $request->except('_token', 'accountId');
        $maxId = Account::where('account_type', request('account_type'))->max('id');
        $request['account_code'] = ($maxId) ? request('account_type')."-".$maxId+1 : request('account_type')."-".'1';
        $this->commonService->findUpdateOrCreate(Account::class, ['id' => ''], $request);

        return redirect('account/accounts-list')->with('message', AccountService::ACCOUNT_SAVED);
    }

    /*
     * Show edit page.
     * */
    public function edit($id){
        $account = Account::find($id);
        $accountTypes = AccountType::pluck('name', 'alias');
        if(empty($account)){
            abort(404);
        }
        return view('accounts.create', compact('account', 'accountTypes'));
    }

    /*
     * update existing resource.
     * @param: $data
     * */
    public function update(StoreAccountRequest $request){
        $request = $request->except('_token','accountId');
        $this->commonService->findUpdateOrCreate(Account::class, ['id' => request('accountId')], $request);
        return redirect('account/accounts-list')->with('message', AccountService::ACCOUNT_UPDATED);
    }

    /*
     * Delete existing resource.
     * @param: request()->id
     * */
    public function delete(){
        $deleted = Account::where('id', request()->id)->delete();
        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => AccountService::ACCOUNT_DELETED]);
        } else {
            return response()->json(['status' => 'fail', 'message' => AccountService::SOME_THING_WENT_WRONG]);
        }
    }

    /*
     * View account detail.
     * @param: $id
     * */
    public function view($id){
        $account = Account::find($id);
        if(empty($account)){
            abort(404);
        }

        return view('accounts.view', compact('account'));
    }
}
