<?php

namespace App\Http\Controllers;

use App\Account;
use App\AccountLedger;
use App\Brand;
use App\Http\Requests\StoreSaleReturnRequest;
use App\Product;
use App\SaleReturnDetail;
use App\SaleReturnMaster;
use App\Services\AccountLedgerService;
use App\Services\CommonService;
use App\Services\ProductService;
use App\Services\SaleReturnService;
use App\Services\StockService;
use App\Stock;
use Illuminate\Support\Facades\DB;

class SalesReturnController extends Controller
{
    protected $productService;
    protected $commonService;
    protected $saleReturnService;
    protected $stockService;
    protected $accountLedgerService;

    public function __construct(ProductService $productService, CommonService $commonService, SaleReturnService $saleReturnService, StockService $stockService, AccountLedgerService $accountLedgerService)
    {
        $this->commonService = $commonService;
        $this->productService = $productService;
        $this->saleReturnService = $saleReturnService;
        $this->stockService = $stockService;
        $this->accountLedgerService = $accountLedgerService;
    }

    /*
     * Show page of list of sale returns.
     * */
    public function index()
    {
        $request = request()->all();
        $salesReturns = $this->saleReturnService->searchSaleReturn($request);
        return view('sales_return.index', compact('salesReturns', 'request'));
    }

    /*
     * Show page of create sale return.
     * */
    public function create()
    {
        $brands = Brand::pluck('name', 'id');
        $products = Product::pluck('name', 'id');
        $customers = Account::where('account_type', 'S')->pluck('name', 'account_code');

        return view('sales_return.create', compact('brands',  'products', 'customers'));
    }

    /*
     * Save sale return into db.
     * @param: @request
     * */
    public function store(StoreSaleReturnRequest $request)
    {
        $request = $request->except('_token', 'saleReturnId');
        try {
            DB::beginTransaction();
            //Insert data into sale return tables.
            $saleReturnMasterData = $this->saleReturnService->prepareSaleReturnMasterData($request);
            $saleReturnMasterInsert = $this->commonService->findUpdateOrCreate(SaleReturnMaster::class, ['id' => ''], $saleReturnMasterData);
            $saleReturnDetailData = $this->saleReturnService->prepareSaleReturnDetailData($request, $saleReturnMasterInsert->id);
            $this->saleReturnService->saveSaleReturn($saleReturnDetailData);

            //Insert data into stock table.
            $this->stockService->prepareAndSaveData($request, $saleReturnMasterInsert->id, SaleReturnService::SALE_RETURN_TRANSACTION_TYPE,);

            //Insert data into accounts ledger table.
            $debitAccountData = $this->saleReturnService->prepareAccountDebitData($request, $saleReturnMasterInsert->id, SaleReturnService::SALE_RETURN_TRANSACTION_TYPE, SaleReturnService::SALE_RETURN_DESCRIPTION);
            $creditAccountData = $this->saleReturnService->prepareAccountCreditData($request, $saleReturnMasterInsert->id, SaleReturnService::SALE_RETURN_TRANSACTION_TYPE, SaleReturnService::SALE_RETURN_DESCRIPTION);
            AccountLedger::insert($debitAccountData);
            AccountLedger::insert($creditAccountData);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('sale-return/create')->with('error', $e->getMessage());
        }
        return redirect('sale-return/sales-return-list')->with('message', SaleReturnService::SALE_RETURN_SAVED);
    }

    /*
     * Show edit page.
     * */
    public function edit($id)
    {
        $brands = Brand::pluck('name', 'id');
        $saleReturn = SaleReturnMaster::find($id);
        $products = Product::where('brand_id', $saleReturn->brand_id)->pluck('name', 'id');
        $customers = Account::where('account_type', 'S')->pluck('name', 'account_code');
        $saleReturnDetails = SaleReturnDetail::where('sale_return_master_id', $id)->get();
        if (empty($saleReturn)) {
            abort(404);
        }

        return view('sales_return.create', compact('saleReturn', 'brands', 'products', 'customers', 'saleReturnDetails'));
    }

    /*
     * update existing resource.
     * @param: $data
     * */
    public function update(StoreSaleReturnRequest $request)
    {
        try {
            DB::beginTransaction();
            $request = request()->all();
            SaleReturnMaster::where('id', $request['saleReturnId'])->delete();
            SaleReturnDetail::where('sale_return_master_id', $request['saleReturnId'])->delete();
            Stock::where('invoice_id', $request['saleReturnId'])->delete();
            AccountLedger::where('invoice_id', $request['saleReturnId'])->delete();

            //Save data into relevant tables.
            $saleReturnMasterData = $this->saleReturnService->prepareSaleReturnMasterData($request);
            $saleReturnMasterInsert = $this->commonService->findUpdateOrCreate(SaleReturnMaster::class, ['id' => request('saleReturnId')], $saleReturnMasterData);
            $saleReturnDetailData = $this->saleReturnService->prepareSaleReturnDetailData($request, $saleReturnMasterInsert->id);
            $this->saleReturnService->saveSaleReturn($saleReturnDetailData);
            //Save data into stock table.
            $this->stockService->prepareAndSaveData($request, $saleReturnMasterInsert->id, SaleReturnService::SALE_RETURN_TRANSACTION_TYPE);

            //Insert data into accounts ledger table.
            $debitAccountData = $this->saleReturnService->prepareAccountDebitData($request, $saleReturnMasterInsert->id, SaleReturnService::SALE_RETURN_TRANSACTION_TYPE, SaleReturnService::SALE_RETURN_DESCRIPTION);
            $creditAccountData = $this->saleReturnService->prepareAccountCreditData($request, $saleReturnMasterInsert->id, SaleReturnService::SALE_RETURN_TRANSACTION_TYPE, SaleReturnService::SALE_RETURN_DESCRIPTION);
            AccountLedger::insert($debitAccountData);
            AccountLedger::insert($creditAccountData);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('sale-return/create')->with('error', $e->getMessage());
        }

        return redirect('sale-return/sales-return-list')->with('message', SaleReturnService::SALE_RETURN_UPDATED);
    }

    /*
     * Delete existing resource.
     * @param: request()->id
     * */
    public function delete()
    {
        try {
            DB::beginTransaction();
            $deleteMaster = SaleReturnMaster::where('id', request()->id)->delete();
            $deleteDetail = SaleReturnDetail::where('sale_return_master_id', request()->id)->delete();
            $deleteStock = Stock::where('invoice_id', request()->id)->delete();
            $accountEntryDetail = AccountLedger::where('invoice_id', request()->id)->delete();
            DB::commit();
            if ($deleteMaster && $deleteDetail && $deleteStock && $accountEntryDetail) {
                return response()->json(['status' => 'success', 'message' => SaleReturnService::SALE_RETURN_DELETED]);
            } else {
                return response()->json(['status' => 'fail', 'message' => SaleReturnService::SOME_THING_WENT_WRONG]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('sales-return/sales-return-list')->with('error', $e->getMessage());
        }
    }

    /*
    * View Sale Return detail.
    * @param: $id
    * */
    public function view($id)
    {
        $saleReturnMaster = $this->saleReturnService->getSaleReturnMasterById($id);
        $saleReturnDetail = $this->saleReturnService->getSaleReturnDetailById($id);
        if (empty($saleReturnMaster)) {
            abort(404);
        }

        return view('sales_return.view', compact('saleReturnMaster', 'saleReturnDetail'));
    }

    /*
     * Get list of products by brand and category.
     * @param: Request $request
     * */
    public function getProductsByBrand()
    {
        $products = $this->saleReturnService->getProductsByCategoryBrand(request()->all());
        if ($products) {
            return json_encode(['status' => 'success', 'data' => $products]);
        } else {
            return response()->json(['status' => 'fail', 'message' => SaleReturnService::SOME_THING_WENT_WRONG]);
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
            return response()->json(['status' => 'fail', 'message' => SaleReturnService::SOME_THING_WENT_WRONG]);
        }
    }
}
