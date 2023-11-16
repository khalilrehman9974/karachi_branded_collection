<?php


namespace App\Services;


use App\Account;
use App\Bank;
use App\Customer;
use App\Party;
use App\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;

class CommonService
{
    const CASH_RECEIPT_VOUCHER = 'crv';
    const CASH_PAYMENT_VOUCHER = 'cpv';
    const BANK_PAYMENT_VOUCHER = 'bpv';
    const BANK_RECEIPT_VOUCHER = 'brv';
    const PER_PAGE = '10';
    /**
     * create or Update content group
     * @param array $model
     * @param array $where
     * @param array $data
     * @return object $object.
     */
    public function findUpdateOrCreate($model, array $where, array $data)
    {
        $object = $model::firstOrNew($where);
        foreach ($data as $property => $value) {
            $object->{$property} = $value;
        }
        $object->save();

        return $object;
    }

    /*
    * Pagination for list of packages.
    * @param: $data
    * @param: $perPage
    * @param: $page
    * @param: $options
    * */
    public function paginate($items, $perPage, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: Self::CURRENT_PAGE);
        $items = $items instanceof Collection ? $items : Collection::make($items)->sortByDesc('id');

        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }

    /*
     * Get drop down data.
     * @return array $result.
     * */
    public function vouchersDropDownData()
    {
        $result = [
            'banks' => Bank::pluck('name','id'),
            'customers' => Customer::pluck('name','id'),
            'parties' => Party::pluck('name','id'),
            'accounts' => Account::pluck('name','account_code'),
            'products' => Product::pluck('name','id'),
        ];

        return $result;
    }

    /*
     * Get Account type name.
     * @param: $type
     * */
    static function getAccountTypeName($type){
        if($type == 'P') {
            return 'Purchase';
        }elseif($type == 'S'){
            return 'Sale';
        }elseif($type == 'CH'){
            return 'Cash In Hand';
        }
    }
}
