<?php

namespace App\Services;

/*
 * Class BankReceiptService
 * @package App\Services
 * */

use App\AccountLedger;
use App\Issuance;
use App\Models\BankReceiptVoucher;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class BankReceiptService
{

    /*
    * Store company data.
    * @param $model
    * @param $where
    * @param $data
    *
    * @return object $object.
    * */
    public function findUpdateOrCreate($model, array $where, array $data)
    {
        $object = $model::firstOrNew($where);

        foreach ($data as $property => $value) {
            $object->{$property} = $value;
        }
        $object->save();

        return $object;
    }

    public function debitDataArray($request, $maxVoucherNo)
    {
        $data = $request->except('_token', 'brvId', 'bank_id');
        $data['date'] = Carbon::parse($request['date'])->format('Y-m-d');
        $data['invoice_id'] = null;
        $data['account_id'] = $request['bank_id'];
        $data['description'] = !empty($request['description']) ? $request['description'] : 'Cash received';
        $data['debit'] = $request['credit'];
        $data['credit'] = 0;
        $data['transaction_type'] = CommonService::BANK_RECEIPT_VOUCHER;
        $data['voucher_number'] = $maxVoucherNo;

        return $data;
    }

    public function creditDataArray($request, $maxVoucherNo)
    {
        $data = $request->except('_token', 'brvId', 'bank_id');
        $data['date'] = Carbon::parse($request['date'])->format('Y-m-d');
        $data['invoice_id'] = null;
        $data['account_id'] = $request['account_id'];
        $data['description'] = !empty($request['description']) ? $request['description'] : 'Cash received';
        $data['debit'] = 0;
        $data['credit'] = $request['credit'];
        $data['transaction_type'] = CommonService::BANK_RECEIPT_VOUCHER;
        $data['voucher_number'] = $maxVoucherNo;

        return $data;
    }

    /*
    * Get Bank Payment Vouchers list.
    * @return object $bpvList.
    * *
    */
    public function getBrvList($request)
    {
        $brvs = AccountLedger::where('transaction_type', CommonService::BANK_RECEIPT_VOUCHER)
            ->where('debit', '>', 0);

        $query = AccountLedger::query();

        if (isset($request['param']) && !empty($request['param'])) {
            $brvs->orWhere('voucher_number', $request['param'])
                ->orWhere('description', 'like', '%' . $request['param'] . '%')
                ->orWhere('debit', $request['param'])
                ->where('credit', '>', 0)
                ->where('transaction_type', CommonService::BANK_RECEIPT_VOUCHER);
        }
        return $brvs->paginate(CommonService::PER_PAGE);
    }


}
