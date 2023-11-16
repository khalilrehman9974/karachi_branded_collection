<?php

namespace App\Services;

use App\Product;
use App\PurchaseDetail;
use App\PurchaseMaster;
use Carbon\Carbon;

class PurchaseService
{
    const PER_PAGE = 10;
    const PURCHASE_SAVED = 'Purchase saved successfully';
    const PURCHASE_UPDATED = 'Purchase updated successfully';
    const PURCHASE_DELETED = 'Purchase is deleted successfully';
    const SOME_THING_WENT_WRONG = 'Oops!Something went wrong';
    const PURCHASE_TRANSACTION_TYPE = 'purchase';
    const PURCHASE_DESCRIPTION = 'Purchased products';

    protected $commonService;

    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }

    /*
     * Get contract by id.
     * @param $id
     * */
    public function getPurchaseMasterById($id)
    {
        return PurchaseMaster::leftjoin('brands', 'brands.id', '=', 'purchase_master.brand_id')
            ->leftjoin('parties', 'parties.id', '=', 'purchase_master.party_id')
            ->select('purchase_master.id as id', 'purchase_master.date', 'parties.name as partyName',
                'brands.name as brandName', 'purchase_master.quantity as totalQuantity',
                'purchase_master.amount as totalAmount', 'parties.id as partyId')
            ->where('purchase_master.id', $id)
            ->first();
    }

    /*
    * Get contract by id.
    * @param $id
    * */
    public function getPurchaseDetailById($id)
    {
        return PurchaseDetail::leftjoin('products', 'purchase_detail.product_id', '=', 'products.id')
            ->select('products.name as productName', 'purchase_detail.price', 'purchase_detail.quantity', 'purchase_detail.amount')
            ->where('purchase_detail.purchase_master_id', $id)
            ->get();
    }

    /*
     * Advance Search data on issuance records.
     * @queries: $queries
     * @return: object
     * */
    public function searchPurchase($request)
    {
        $query = PurchaseMaster::groupBy('purchase_master.id', 'purchase_master.date', 'purchase_master.party_id', 'purchase_master.brand_id', 'purchase_master.amount',
            'purchase_master.quantity', 'purchase_master.created_at', 'purchase_master.updated_at');
        if (!empty($request['param'])) {
            $query = $query->where('purchase_master.id', "=", $request['param']);
//            $query = $query->orwhere('parties.name', "% like %", $request['param']);
        }
//        $query->select('purchase_master.id','purchase_master.date','purchase_master.amount','purchase_master.quantity');
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
    public function preparePurchaseMasterData($request)
    {
        return [
            'date' => Carbon::parse($request['date'])->format('Y-m-d'),
            'party_id' => $request['party_id'],
            'brand_id' => $request['brand_id'],
            'amount' => array_sum($request['amount']),
            'quantity' => array_sum($request['quantity']),
        ];
    }

    /*
     * Prepare purchase detail data.
     * @param: $request
     * @return Array
     * */
    public function preparePurchaseDetailData($request, $purchaseParentId)
    {
        return [
            'product_id' => $request['product_id'],
            'price' => $request['price'],
            'quantity' => $request['quantity'],
            'amount' => $request['amount'],
            'purchase_master_id' => $purchaseParentId,

        ];
    }

    public function savePurchase($data)
    {
        foreach ($data['product_id'] as $key => $value) {
            if (!empty($data['product_id'][$key])) {
                $rec['product_id'] = $data['product_id'][$key];
                $rec['price'] = $data['price'][$key];
                $rec['quantity'] = $data['quantity'][$key];
                $rec['amount'] = $data['amount'][$key];
                $rec['purchase_master_id'] = $data['purchase_master_id'];
                PurchaseDetail::create($rec);
            }
        }
    }

}
