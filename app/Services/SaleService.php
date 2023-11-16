<?php
namespace App\Services;

use App\Product;
use App\SaleDetail;
use App\SaleMaster;
use Carbon\Carbon;

class SaleService
{
    const PER_PAGE = 10;
    const SALE_SAVED = 'Sale saved successfully';
    const SALE_UPDATED = 'Sale updated successfully';
    const SALE_DELETED = 'Sale is deleted successfully';
    const SOME_THING_WENT_WRONG = 'Oops!Something went wrong';
    const SALE_TRANSACTION_TYPE = 'sale';
    const SALE_DESCRIPTION = 'Saled products';

    protected $commonService;

    public function __construct(CommonService $commonService)
    {
        $this->commonService = $commonService;
    }

    /*
     * Get contract by id.
     * @param $id
     * */
    public function getSaleMasterById($id)
    {
        return SaleMaster::leftjoin('brands', 'brands.id', '=', 'sale_master.brand_id')
            ->leftjoin('customers', 'customers.id', '=', 'sale_master.customer_id')
            ->select('sale_master.id as id', 'sale_master.date', 'customers.name as customerName',
                'brands.name as brandName', 'sale_master.quantity as totalQuantity',
                'sale_master.amount as totalAmount', 'customers.id as customerId', 'sale_master.tracking_number')
            ->where('sale_master.id', $id)
            ->first();
    }

    /*
    * Get contract by id.
    * @param $id
    * */
    public function getSaleDetailById($id)
    {
        return SaleDetail::leftjoin('products', 'sale_detail.product_id', '=', 'products.id')
            ->select('products.name as productName', 'sale_detail.price', 'sale_detail.quantity', 'sale_detail.amount')
            ->where('sale_detail.sale_master_id', $id)
            ->get();
    }

    /*
     * Search sale record.
     * @queries: $queries
     * @return: object
     * */
    public function searchSale($request)
    {
        $query = SaleMaster::groupBy('sale_master.id', 'sale_master.date', 'sale_master.customer_id', 'sale_master.brand_id', 'sale_master.amount',
            'sale_master.quantity', 'sale_master.remarks', 'sale_master.created_at', 'sale_master.tracking_number', 'sale_master.updated_at');
        if (!empty($request['param'])) {
            $query = $query->where('sale_master.id', "=", $request['param']);
//            $query = $query->orwhere('parties.name', "% like %", $request['param']);
        }
//        $query->select('sale_master.id','sale_master.date','sale_master.amount','sale_master.quantity');
        $sales = $query->orderBy('id', 'DESC')->get();

        return $this->commonService->paginate($sales, Self::PER_PAGE);
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
     * Prepare sale master data.
     * @param: $request
     * @return Array
     * */
    public function prepareSaleMasterData($request)
    {
        return [
            'date' => Carbon::parse($request['date'])->format('Y-m-d'),
            'customer_id' => $request['customer_id'],
            'brand_id' => $request['brand_id'],
            'amount' => array_sum($request['amount']),
            'quantity' => array_sum($request['quantity']),
            'tracking_number' => $request['tracking_number'],
            'remarks' => $request['remarks'],
        ];
    }

    /*
     * Prepare sale detail data.
     * @param: $request
     * @return Array
     * */
    public function prepareSaleDetailData($request, $saleParentId)
    {
        return [
            'product_id' => $request['product_id'],
            'price' => $request['price'],
            'quantity' => $request['quantity'],
            'amount' => $request['amount'],
            'sale_master_id' => $saleParentId,
        ];
    }

    /*
     * Save sale data.
     * @param: $data
     * */
    public function saveSale($data)
    {
        foreach ($data['product_id'] as $key => $value) {
            if (!empty($data['product_id'][$key])) {
                $rec['product_id'] = $data['product_id'][$key];
                $rec['price'] = $data['price'][$key];
                $rec['quantity'] = $data['quantity'][$key];
                $rec['amount'] = $data['amount'][$key];
                $rec['sale_master_id'] = $data['sale_master_id'];
                SaleDetail::create($rec);
            }
        }
    }

    public function prepareAccountCreditData($request, $saleParentId, $dataType, $description)
    {
        return [
            'date' => Carbon::parse($request['date'])->format('Y-m-d'),
            'invoice_id' => $saleParentId,
            'account_id' => 'S-00000001',
            'description' => $description . ' '. $saleParentId,
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
            'account_id' => $request['customer_id'],
            'description' => $description . ' '. $saleParentId,
            'transaction_type' => $dataType,
            'debit' => $request['totalAmount'],
            'credit' => 0,
        ];
    }
}
