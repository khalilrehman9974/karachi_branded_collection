<?php

namespace App\Services;

use App\Product;
use App\PurchaseReturnDetail;
use App\PurchaseReturnMaster;
use Carbon\Carbon;

class PurchaseReturnService
{
    const PER_PAGE = 10;
    const PURCHASE_RETURN_SAVED = 'Purchase return saved successfully';
    const PURCHASE_RETURN_UPDATED = 'Purchase return updated successfully';
    const PURCHASE_RETURN_DELETED = 'Purchase return is deleted successfully';
    const SOME_THING_WENT_WRONG = 'Oops!Something went wrong';
    const PURCHASE_RETURN_TRANSACTION_TYPE = 'purchase_return';
    const PURCHASE_RETURN_DESCRIPTION = 'Purchased Return Products';

    protected $commonService;

    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }

    /*
     * Get contract by id.
     * @param $id
     * */
    public function getPurchaseReturnMasterById($id)
    {
        return PurchaseReturnMaster::leftjoin('brands', 'brands.id', '=', 'purchase_return_master.brand_id')
            ->leftjoin('parties', 'parties.id', '=', 'purchase_return_master.party_id')
            ->select('purchase_return_master.id as id', 'purchase_return_master.date', 'parties.name as partyName',
                'brands.name as brandName', 'purchase_return_master.quantity as totalQuantity',
                'purchase_return_master.amount as totalAmount', 'parties.id as partyId')
            ->where('purchase_return_master.id', $id)
            ->first();
    }

    /*
    * Get contract by id.
    * @param $id
    * */
    public function getPurchaseReturnDetailById($id)
    {
        return PurchaseReturnDetail::leftjoin('products', 'purchase_return_detail.product_id', '=', 'products.id')
            ->select('products.name as productName', 'purchase_return_detail.price', 'purchase_return_detail.quantity', 'purchase_return_detail.amount')
            ->where('purchase_return_detail.purchase_return_master_id', $id)
            ->get();
    }

    /*
     * Advance Search data on issuance records.
     * @queries: $queries
     * @return: object
     * */
    public function searchPurchaseReturn($request)
    {
        $query = PurchaseReturnMaster::groupBy('purchase_return_master.id', 'purchase_return_master.date', 'purchase_return_master.party_id', 'purchase_return_master.brand_id', 'purchase_return_master.amount',
            'purchase_return_master.quantity', 'purchase_return_master.created_at', 'purchase_return_master.updated_at', 'purchase_return_master.remarks');
        if (!empty($request['param'])) {
            $query = $query->where('purchase_return_master.id', "=", $request['param']);
//            $query = $query->orwhere('parties.name', "% like %", $request['param']);
        }
//        $query->select('purchase_return_master.id','purchase_return_master.date','purchase_return_master.amount','purchase_return_master.quantity');
        $purchases = $query->orderBy('id', 'DESC')->get();

        return $this->commonService->paginate($purchases, Self::PER_PAGE);
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
     * Prepare purchase master data.
     * @param: $request
     * @return Array
     * */
    public function preparePurchaseReturnMasterData($request)
    {
        return [
            'date' => Carbon::parse($request['date'])->format('Y-m-d'),
            'party_id' => $request['party_id'],
            'brand_id' => $request['brand_id'],
            'amount' => array_sum($request['amount']),
            'quantity' => array_sum($request['quantity']),
            'remarks' => $request['remarks'],
        ];
    }

    /*
     * Prepare purchase detail data.
     * @param: $request
     * @return Array
     * */
    public function preparePurchaseReturnDetailData($request, $purchaseParentId)
    {
        return [
            'product_id' => $request['product_id'],
            'price' => $request['price'],
            'quantity' => $request['quantity'],
            'amount' => $request['amount'],
            'purchase_return_master_id' => $purchaseParentId,
        ];
    }

    public function savePurchaseReturn($data)
    {
        foreach ($data['product_id'] as $key => $value) {
            if (!empty($data['product_id'][$key])) {
                $rec['product_id'] = $data['product_id'][$key];
                $rec['price'] = $data['price'][$key];
                $rec['quantity'] = $data['quantity'][$key];
                $rec['amount'] = $data['amount'][$key];
                $rec['purchase_return_master_id'] = $data['purchase_return_master_id'];
                PurchaseReturnDetail::create($rec);
            }
        }
    }

    public function prepareAccountCreditData($request, $purchaseParentId, $dataType, $description)
    {
        return [
            'date' => Carbon::parse($request['date'])->format('Y-m-d'),
            'invoice_id' => $purchaseParentId,
            'account_id' => 'PR-00000001',
            'description' => $description . ' '. $purchaseParentId,
            'transaction_type' => $dataType,
            'debit' => 0,
            'credit' => $request['totalAmount'],

        ];
    }

    public function prepareAccountDebitData($request, $purchaseParentId, $dataType, $description)
    {
        return [
            'date' => Carbon::parse($request['date'])->format('Y-m-d'),
            'invoice_id' => $purchaseParentId,
            'account_id' => $request['party_id'],
            'description' => $description . ' '. $purchaseParentId,
            'transaction_type' => $dataType,
            'debit' => $request['totalAmount'],
            'credit' => 0,

        ];
    }

}
