<?php

namespace App\Services;

/*
 * Class CashPaymentService
 * @package App\Services
 * */

use App\AccountLedger;
use Carbon\Carbon;

class CashPaymentService
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

    public function dataArrayDebit($request, $masterVoucherNumber)
    {
        $data = $request->except('_token','cpvId');
        $data['date'] = Carbon::parse($request['date'])->format('Y-m-d');
        $data['invoice_id'] = null;
        $data['account_id'] = $request['account_id'];
        $data['description'] = !empty($request['description']) ? $request['description'] : 'Cash received';
        $data['credit'] = 0;
        $data['debit'] = $request['debit'];
        $data['transaction_type'] = CommonService::CASH_PAYMENT_VOUCHER;
        $data['voucher_number'] = $masterVoucherNumber;

        return $data;
    }

    public function dataArrayCredit($request,$masterVoucherNumber)
    {
        $data = $request->except('_token','cpvId');
        $data['date'] = Carbon::parse($request['date'])->format('Y-m-d');
        $data['invoice_id'] = null;
        $data['account_id'] = 'CH-00001';
        $data['description'] = !empty($request['description']) ? $request['description'] : 'Cash received';
        $data['credit'] = $request['debit'];
        $data['debit'] = 0;
        $data['transaction_type'] = CommonService::CASH_PAYMENT_VOUCHER;
        $data['voucher_number'] = $masterVoucherNumber;

        return $data;
    }

    /*
    * Get Bank Receipt Vouchers list.
    * @return object $bpvList.
    * *
    */
    public function getCpvList()
    {
        return AccountLedger::where('transaction_type', CommonService::CASH_PAYMENT_VOUCHER)->where('account_id', '<>', 'CH-00001')->paginate(CommonService::PER_PAGE);
    }
}
