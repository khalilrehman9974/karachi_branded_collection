<?php

namespace App\Services;

use App\AccountLedger;
use Carbon\Carbon;

/*
 * Class BankPaymentService
 * @package App\Services
 * */
class BankPaymentService
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
        $data = $request->except('_token','bpvId','bank_id');
        $data['date'] = Carbon::parse($request['date'])->format('Y-m-d');
        $data['invoice_id'] = null;
        $data['account_id'] = $request['account_id'];
        $data['description'] = !empty($request['description']) ? $request['description'] : 'Cash received';
        $data['debit'] = $request['credit'];
        $data['credit'] = 0;
        $data['transaction_type'] = CommonService::BANK_PAYMENT_VOUCHER;
        $data['voucher_number'] = $maxVoucherNo;

        return $data;
    }

    public function creditDataArray($request, $maxVoucherNo)
    {
        $data = $request->except('_token','bpvId','bank_id');
        $data['date'] = Carbon::parse($request['date'])->format('Y-m-d');
        $data['invoice_id'] = null;
        $data['account_id'] = $request['bank_id'];
        $data['description'] = !empty($request['description']) ? $request['description'] : 'Cash received';
        $data['debit'] = 0;
        $data['credit'] = $request['credit'];
        $data['transaction_type'] = CommonService::BANK_PAYMENT_VOUCHER;
        $data['voucher_number'] = $maxVoucherNo;

        return $data;
    }

    /*
    * Get Bank Payment Vouchers list.
    * @return object $bpvList.
    * *
    */
    public function getBpvList()
    {
        return AccountLedger::where('transaction_type', CommonService::BANK_PAYMENT_VOUCHER)
            ->where('credit',">", 0)
            ->paginate(CommonService::PER_PAGE);
    }

}
