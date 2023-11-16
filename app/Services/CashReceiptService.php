<?php

namespace App\Services;

/*
 * Class CashReceiptService
 * @package App\Services
 * */

use App\AccountLedger;
use Carbon\Carbon;

class CashReceiptService
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

    public function dataArrayCredit($request, $masterVoucherNumber)
    {
        $data = $request->except('_token','crvId');
        $data['date'] = Carbon::parse($request['date'])->format('Y-m-d');
        $data['invoice_id'] = null;
        $data['account_id'] = $request['account_id'];
        $data['description'] = !empty($request['description']) ? $request['description'] : 'Cash received';
        $data['credit'] = $request['credit'];
        $data['debit'] = 0;
        $data['transaction_type'] = CommonService::CASH_RECEIPT_VOUCHER;
        $data['voucher_number'] = $masterVoucherNumber;

        return $data;
    }

    public function dataArrayDebit($request, $masterVoucherNumber)
    {
        $data = $request->except('_token','crvId');
        $data['date'] = Carbon::parse($request['date'])->format('Y-m-d');
        $data['invoice_id'] = null;
        $data['account_id'] = 'CH-00001';
        $data['description'] = !empty($request['description']) ? $request['description'] : 'Cash received';
        $data['credit'] = 0;
        $data['debit'] = $request['credit'];
        $data['transaction_type'] = CommonService::CASH_RECEIPT_VOUCHER;
        $data['voucher_number'] = $masterVoucherNumber;

        return $data;
    }

    /*
    * Get Bank Receipt Vouchers list.
    * @return object $bpvList.
    * *
    */
    public function getCrvList()
    {
        return AccountLedger::where('transaction_type', CommonService::CASH_RECEIPT_VOUCHER)->where('account_id', '<>', 'CH-00001')->paginate(CommonService::PER_PAGE);
    }
}
