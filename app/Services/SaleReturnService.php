<?php

namespace App\Services;

use App\Product;
use App\SaleReturnDetail;
use App\SaleReturnMaster;
use Carbon\Carbon;

class SaleReturnService
{
    const PER_PAGE = 10;
    const SALE_RETURN_SAVED = 'Sale Return saved successfully';
    const SALE_RETURN_UPDATED = 'Sale Return updated successfully';
    const SALE_RETURN_DELETED = 'Sale Return is deleted successfully';
    const SOME_THING_WENT_WRONG = 'Oops!Something went wrong';
    const SALE_RETURN_TRANSACTION_TYPE = 'sale_return';
    const SALE_RETURN_DESCRIPTION = 'Products returned';

    protected $commonService;

    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }

    /*
     * Get sale master by id.
     * @param $id
     * */
    public function getSaleReturnMasterById($id)
    {
        return SaleReturnMaster::leftjoin('brands', 'brands.id', '=', 'sale_return_master.brand_id')
            ->leftjoin('customers', 'customers.id', '=', 'sale_return_master.customer_id')
            ->select('sale_return_master.id as id', 'sale_return_master.date', 'customers.name as customerName',
                'brands.name as brandName', 'sale_return_master.quantity as totalQuantity',
                'sale_return_master.amount as totalAmount', 'customers.id as customerId')
            ->where('sale_return_master.id', $id)
            ->first();
    }

    /*
    * Get sale detail by id.
    * @param $id
    * */
    public function getSaleReturnDetailById($id)
    {
        return SaleReturnDetail::leftjoin('products', 'sale_return_detail.product_id', '=', 'products.id')
            ->select('products.name as productName', 'sale_return_detail.price', 'sale_return_detail.quantity', 'sale_return_detail.amount')
            ->where('sale_return_detail.sale_return_master_id', $id)
            ->get();
    }

    /*
     * Search data on sale return.
     * @queries: $queries
     * @return: object
     * */
    public function searchSaleReturn($request)
    {
        $query = SaleReturnMaster::groupBy('sale_return_master.id', 'sale_return_master.date', 'sale_return_master.customer_id', 'sale_return_master.brand_id', 'sale_return_master.amount',
            'sale_return_master.quantity', 'sale_return_master.created_at', 'sale_return_master.updated_at','sale_return_master.tracking_number','sale_return_master.remarks');

        if (!empty($request['param'])) {
            $query = $query->where('sale_return_master.id', "=", $request['param']);
//            $query = $query->orwhere('parties.name', "% like %", $request['param']);
        }
//        $query->select('sale_return_master.id','sale_return_master.date','sale_return_master.amount','sale_return_master.quantity');
        $saleReturns = $query->orderBy('id', 'DESC')->get();

        return $this->commonService->paginate($saleReturns, Self::PER_PAGE);
    }

    /*
     * Get list of products for selected category and brand.
     * @param: $request
     * @return Array
     * */
    public function getProductsByCategoryBrand($request)
    {
        return Product::where('brand_id', $request['brandCode'])->get();
    }

    /*
     * Prepare sale return master data.
     * @param: $request
     * @return Array
     * */
    public function prepareSaleReturnMasterData($request)
    {
        return [
            'date' => Carbon::parse($request['date'])->format('Y-m-d'),
            'customer_id' => $request['customer_id'],
            'brand_id' => $request['brand_id'],
            'amount' => array_sum($request['amount']),
            'quantity' => array_sum($request['quantity']),
            'remarks' => $request['remarks'],
        ];
    }

    /*
     * Prepare sale return detail data.
     * @param: $request
     * @return Array
     * */
    public function prepareSaleReturnDetailData($request, $saleReturnParentId)
    {
        return [
            'product_id' => $request['product_id'],
            'price' => $request['price'],
            'quantity' => $request['quantity'],
            'amount' => $request['amount'],
            'sale_return_master_id' => $saleReturnParentId,

        ];
    }

    public function saveSaleReturn($data)
    {
        foreach ($data['product_id'] as $key => $value) {
            if (!empty($data['product_id'][$key])) {
                $rec['product_id'] = $data['product_id'][$key];
                $rec['price'] = $data['price'][$key];
                $rec['quantity'] = $data['quantity'][$key];
                $rec['amount'] = $data['amount'][$key];
                $rec['sale_return_master_id'] = $data['sale_return_master_id'];
                SaleReturnDetail::create($rec);
            }
        }
    }

    public function prepareAccountCreditData($request, $saleParentId, $dataType, $description)
    {
        return [
            'date' => Carbon::parse($request['date'])->format('Y-m-d'),
            'invoice_id' => $saleParentId,
            'account_id' => $request['customer_id'],
            'description' => $description . ' against invoice# '. $saleParentId,
            'transaction_type' => $dataType,
            'debit' => 0,
            'credit' => $request['totalAmount'],
        ];
    }

    public function prepareAccountDebitData($request, $saleParentId, $dataType, $description)
    {
        return [
            'date' => Carbon::parse($request['date'])->format('Y-m-d'),
            'invoice_id' => $saleParentId,
            'account_id' => 'SR-00000001',
            'description' => $description . ' against invoice# '. $saleParentId,
            'transaction_type' => $dataType,
            'debit' => $request['totalAmount'],
            'credit' => 0,
        ];
    }

}
