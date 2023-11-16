<?php


namespace App\Services;


use App\Account;
use Carbon\Carbon;

class AccountService
{
    const PER_PAGE = 10;
    const ACCOUNT_SAVED = 'Account saved successfully';
    const ACCOUNT_UPDATED = 'Account updated successfully';
    const ACCOUNT_DELETED = 'Account is deleted successfully';
    const SOME_THING_WENT_WRONG = 'Oops!Something went wrong';

    protected $commonService;

    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }

    /*
     * Advance Search data on accounts.
     * @queries: $queries
     * @return: object
     * */
    public function searchAccount($request)
    {
        $accounts = [];
        $query = Account::get();
        if (!empty($request)) {
            if(!empty($request['param'])){
                $query = Account::where('name', 'like', '%' . $request['param'] . '%')
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
            $query = $query->where('account_code', '!=', 'CH-00001');
        }

        if(!empty($request['param'])){
            $accounts = $query->get();
        }else{
            $accounts = $query;
        }

        return $this->commonService->paginate($accounts, Self::PER_PAGE);
    }
}
