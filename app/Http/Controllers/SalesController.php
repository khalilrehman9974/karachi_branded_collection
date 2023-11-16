<?php

namespace App\Http\Controllers;

use App\Account;
use App\AccountLedger;
use App\Brand;
use App\Http\Requests\StoreSaleRequest;
use App\Party;
use App\Product;
use App\SaleDetail;
use App\SaleMaster;
use App\Services\AccountLedgerService;
use App\Services\CommonService;
use App\Services\ProductService;
use App\Services\SaleService;
use App\Services\StockService;
use App\Stock;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    protected $productService;
    protected $commonService;
    protected $saleService;
    protected $stockService;
    protected $accountLedgerService;

    public function __construct(ProductService $productService, CommonService $commonService, SaleService $saleService, StockService $stockService, AccountLedgerService $accountLedgerService)
    {
        $this->commonService = $commonService;
        $this->productService = $productService;
        $this->saleService = $saleService;
        $this->stockService = $stockService;
        $this->accountLedgerService = $accountLedgerService;
    }

    /*
     * Show page of list of sales.
     * */
    public function index()
    {
        $request = request()->all();
        $sales = $this->saleService->searchSale($request);

            return view('sales.index', compact('sales', 'request'));
    }

    /*
     * Show page of create sale.
     * */
    public function create()
    {
        $brands = Brand::pluck('name', 'id');
        $products = Product::pluck('name', 'id');
        $customers = Account::where('account_type', 'S')->pluck('name', 'account_code');

        return view('sales.create', compact('brands',  'products', 'customers'));
    }

    /*
     * Save sale into db.
     * @param: @request
     * */
    public function store(StoreSaleRequest $request)
    {
        $request = $request->except('_token', 'saleId');
        try {
            DB::beginTransaction();
            //Insert data into sale tables.
            $saleMasterData = $this->saleService->prepareSaleMasterData($request);
            $saleMasterInsert = $this->commonService->findUpdateOrCreate(SaleMaster::class, ['id' => ''], $saleMasterData);
            $saleDetailData = $this->saleService->prepareSaleDetailData($request, $saleMasterInsert->id);
            $this->saleService->saveSale($saleDetailData);

            //Insert data into stock table.
            $this->stockService->prepareAndSaveData($request, $saleMasterInsert->id, SaleService::SALE_TRANSACTION_TYPE);

            //Insert data into accounts ledger table.
            $debitAccountData = $this->saleService->prepareAccountDebitData($request, $saleMasterInsert->id, SaleService::SALE_TRANSACTION_TYPE, SaleService::SALE_DESCRIPTION);
            $creditAccountData = $this->saleService->prepareAccountCreditData($request, $saleMasterInsert->id, SaleService::SALE_TRANSACTION_TYPE, SaleService::SALE_DESCRIPTION);
            AccountLedger::insert($debitAccountData);
            AccountLedger::insert($creditAccountData);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('sale/create')->with('error', $e->getMessage());
        }
        return redirect('sale/sales-list')->with('message', SaleService::SALE_SAVED);
    }

    /*
     * Show edit page.
     * */
    public function edit($id)
    {
        $brands = Brand::pluck('name', 'id');
        $sale = SaleMaster::find($id);
        $products = Product::where('brand_id', $sale->brand_id)->pluck('name', 'id');
        $customers = Account::where('account_type', 'S')->pluck('name', 'id');
        $saleDetails = SaleDetail::where('sale_master_id', $id)->get();
        if (empty($sale)) {
            abort(404);
        }

        return view('sales.create', compact('sale', 'brands', 'products', 'customers', 'saleDetails'));
    }

    /*
     * update existing resource.
     * @param: $data
     * */
    public function update(StoreSaleRequest $request)
    {
        try {
            DB::beginTransaction();
            $request = request()->all();
            SaleMaster::where('id', $request['saleId'])->delete();
            SaleDetail::where('sale_master_id', $request['saleId'])->delete();
            Stock::where('invoice_id', $request['saleId'])->delete();
            AccountLedger::where('invoice_id', $request['saleId'])->delete();

            //Save data into relevant tables.
            $saleMasterData = $this->saleService->prepareSaleMasterData($request);
            $saleMasterInsert = $this->commonService->findUpdateOrCreate(SaleMaster::class, ['id' => request('productId')], $saleMasterData);
            $saleDetailData = $this->saleService->prepareSaleDetailData($request, $saleMasterInsert->id);
            $this->saleService->saveSale($saleDetailData);

            //Save data into stock table.
            $this->stockService->prepareAndSaveData($request, $saleMasterInsert->id, SaleService::SALE_TRANSACTION_TYPE);
            $debitAccountData = $this->saleService->prepareAccountDebitData($request, $saleMasterInsert->id, SaleService::SALE_TRANSACTION_TYPE, SaleService::SALE_DESCRIPTION);
            $creditAccountData = $this->saleService->prepareAccountCreditData($request, $saleMasterInsert->id, SaleService::SALE_TRANSACTION_TYPE, SaleService::SALE_DESCRIPTION);
            AccountLedger::insert($debitAccountData);
            AccountLedger::insert($creditAccountData);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('sale/create')->with('error', $e->getMessage());
        }

        return redirect('sale/sales-list')->with('message', SaleService::SALE_UPDATED);
    }

    /*
     * Delete existing resource.
     * @param: request()->id
     * */
    public function delete()
    {
        try {
            DB::beginTransaction();
            $deleteMaster = SaleMaster::where('id', request()->id)->delete();
            $deleteDetail = SaleDetail::where('sale_master_id', request()->id)->delete();
            $deleteStock = Stock::where('invoice_id', request()->id)->delete();
            $accountEntryDetail = AccountLedger::where('invoice_id', request()->id)->delete();
            DB::commit();
            if ($deleteMaster && $deleteDetail && $deleteStock && $accountEntryDetail) {
                return response()->json(['status' => 'success', 'message' => SaleService::SALE_DELETED]);
            } else {
                return response()->json(['status' => 'fail', 'message' => SaleService::SOME_THING_WENT_WRONG]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('sale/sales-list')->with('error', $e->getMessage());
        }
    }

    /*
    * View sale detail.
    * @param: $id
    * */
    public function view($id)
    {
        $saleMaster = $this->saleService->getSaleMasterById($id);
        $saleDetail = $this->saleService->getSaleDetailById($id);
        if (empty($saleMaster)) {
            abort(404);
        }

        return view('sales.view', compact('saleMaster', 'saleDetail'));
    }

    /*
     * Get list of products by brand and category.
     * @param: Request $request
     * */
    public function getProductsByBrand()
    {
        $products = $this->saleService->getProductsByCategoryBrand(request()->all());
        if ($products) {
            return json_encode(['status' => 'success', 'data' => $products]);
        } else {
            return response()->json(['status' => 'fail', 'message' => SaleService::SOME_THING_WENT_WRONG]);
        }
    }

    /*
     * Get product detail
     * @param: request('productCode')
     * */
    public function getProductDetail()
    {
        $product = $this->productService->getById(request('productCode'));
        if ($product) {
            return json_encode(['status' => 'success', 'data' => $product]);
        } else {
            return response()->json(['status' => 'fail', 'message' => SaleService::SOME_THING_WENT_WRONG]);
        }
    }
}
