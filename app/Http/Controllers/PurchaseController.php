<?php

namespace App\Http\Controllers;

use App\Account;
use App\AccountLedger;
use App\Brand;
use App\Category;
use App\Http\Requests\StorePurchaseRequest;
use App\Product;
use App\PurchaseDetail;
use App\PurchaseMaster;
use App\Services\AccountLedgerService;
use App\Services\CommonService;
use App\Services\ProductService;
use App\Services\PurchaseService;
use App\Services\StockService;
use App\Stock;
use Illuminate\Support\Facades\DB;

class PurchaseController extends Controller
{
    protected $productService;
    protected $commonService;
    protected $purchaseService;
    protected $stockService;
    protected $accountLedgerService;

    public function __construct(ProductService $productService, CommonService $commonService, PurchaseService $purchaseService, StockService $stockService, AccountLedgerService $accountLedgerService)
    {
        $this->commonService = $commonService;
        $this->productService = $productService;
        $this->purchaseService = $purchaseService;
        $this->stockService = $stockService;
        $this->accountLedgerService = $accountLedgerService;
    }

    /*
     * Show page of list of purchases.
     * */
    public function index()
    {
        $request = request()->all();
        $purchases = $this->purchaseService->searchPurchase($request);
        return view('purchase.index', compact('purchases', 'request'));
    }

    /*
     * Show page of create purchase.
     * */
    public function create()
    {
        $brands = Brand::pluck('name', 'id');
        $categories = Category::pluck('name', 'id');
        $products = Product::pluck('name', 'id');
        $parties = Account::where('account_type', 'P')->pluck('name', 'account_code');

        return view('purchase.create', compact('brands', 'categories', 'products', 'parties'));
    }

    /*
     * Save purchase into db.
     * @param: @request
     * */
    public function store(StorePurchaseRequest $request)
    {
        $request = $request->except('_token', 'purchaseId');
        try {
            DB::beginTransaction();
            //Insert data into purchase tables.
            $purchaseMasterData = $this->purchaseService->preparePurchaseMasterData($request);
            $purchaseMasterInsert = $this->commonService->findUpdateOrCreate(PurchaseMaster::class, ['id' => ''], $purchaseMasterData);
            $purchaseDetailData = $this->purchaseService->preparePurchaseDetailData($request, $purchaseMasterInsert->id);
            $this->purchaseService->savePurchase($purchaseDetailData);
            //Insert data into stock table.
            $stockData = $this->stockService->prepareAndSaveData($request, $purchaseMasterInsert->id, PurchaseService::PURCHASE_TRANSACTION_TYPE,);
            //Insert data into accounts ledger table.
            $creditAccountData = $this->accountLedgerService->prepareCreditData($request, $purchaseMasterInsert->id, PurchaseService::PURCHASE_TRANSACTION_TYPE, PurchaseService::PURCHASE_DESCRIPTION);
            $debitAccountData = $this->accountLedgerService->prepareDebitData($request, $purchaseMasterInsert->id, PurchaseService::PURCHASE_TRANSACTION_TYPE, PurchaseService::PURCHASE_DESCRIPTION);
            AccountLedger::insert($creditAccountData);
            AccountLedger::insert($debitAccountData);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('purchase/create')->with('error', $e->getMessage());
        }
        return redirect('purchase/purchase-list')->with('message', PurchaseService::PURCHASE_SAVED);
    }

    /*
     * Show edit page.
     * */
    public function edit($id)
    {
        $brands = Brand::pluck('name', 'id');
        $purchase = PurchaseMaster::find($id);
        $products = Product::where('brand_id', $purchase->brand_id)->pluck('name', 'id');
        $parties = Account::where('account_type', 'P')->pluck('name', 'id');
        $purchaseDetails = PurchaseDetail::where('purchase_master_id', $id)->get();
        if (empty($purchase)) {
            abort(404);
        }

        return view('purchase.create', compact('purchase', 'brands', 'products', 'parties', 'purchaseDetails'));
    }

    /*
     * update existing resource.
     * @param: $data
     * */
    public function update(StorePurchaseRequest $request)
    {
        try {
            DB::beginTransaction();
            $request = request()->all();
            PurchaseMaster::where('id', $request['purchaseId'])->delete();
            PurchaseDetail::where('purchase_master_id', $request['purchaseId'])->delete();
            Stock::where('invoice_id', $request['purchaseId'])->delete();
            AccountLedger::where('invoice_id', $request['purchaseId'])->delete();

            //Save data into relevant tables.
            $purchaseMasterData = $this->purchaseService->preparePurchaseMasterData($request);
            $purchaseMasterInsert = $this->commonService->findUpdateOrCreate(PurchaseMaster::class, ['id' => request('productId')], $purchaseMasterData);
            $purchaseDetailData = $this->purchaseService->preparePurchaseDetailData($request, $purchaseMasterInsert->id);
            $this->purchaseService->savePurchase($purchaseDetailData);
            //Save data into stock table.
            $this->stockService->prepareAndSaveData($request, $purchaseMasterInsert->id, PurchaseService::PURCHASE_TRANSACTION_TYPE);
            $creditAccountData = $this->accountLedgerService->prepareCreditData($request, $purchaseMasterInsert->id, PurchaseService::PURCHASE_TRANSACTION_TYPE, PurchaseService::PURCHASE_DESCRIPTION);
            $debitAccountData = $this->accountLedgerService->prepareDebitData($request, $purchaseMasterInsert->id, PurchaseService::PURCHASE_TRANSACTION_TYPE, PurchaseService::PURCHASE_DESCRIPTION);
            AccountLedger::insert($creditAccountData);
            AccountLedger::insert($debitAccountData);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('purchase/purchase-list')->with('error', $e->getMessage());
        }

        return redirect('purchase/purchase-list')->with('message', PurchaseService::PURCHASE_UPDATED);
    }

    /*
     * Delete existing resource.
     * @param: request()->id
     * */
    public function delete()
    {
        try {
            DB::beginTransaction();
            $deleteMaster = PurchaseMaster::where('id', request()->id)->delete();
            $deleteDetail = PurchaseDetail::where('purchase_master_id', request()->id)->delete();
            $deleteStock = Stock::where('invoice_id', request()->id)->delete();
            $accountEntryDetail = AccountLedger::where('invoice_id', request()->id)->delete();
            DB::commit();
            if ($deleteMaster && $deleteDetail && $deleteStock && $accountEntryDetail) {
                return response()->json(['status' => 'success', 'message' => PurchaseService::PURCHASE_DELETED]);
            } else {
                return response()->json(['status' => 'fail', 'message' => PurchaseService::SOME_THING_WENT_WRONG]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('purchase/purchase-list')->with('error', $e->getMessage());
        }
    }

    /*
    * View Purchase detail.
    * @param: $id
    * */
    public function view($id)
    {
        $purchaseMaster = $this->purchaseService->getPurchaseMasterById($id);
        $purchaseDetail = $this->purchaseService->getPurchaseDetailById($id);
        if (empty($purchaseMaster)) {
            abort(404);
        }

        return view('purchase.view', compact('purchaseMaster', 'purchaseDetail'));
    }

    /*
     * Get list of products by brand and category.
     * @param: Request $request
     * */
    public function getProductsByBrand()
    {
        $products = $this->purchaseService->getProductsByCategoryBrand(request()->all());
        if ($products) {
            return json_encode(['status' => 'success', 'data' => $products]);
        } else {
            return response()->json(['status' => 'fail', 'message' => PurchaseService::SOME_THING_WENT_WRONG]);
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
            return response()->json(['status' => 'fail', 'message' => PurchaseService::SOME_THING_WENT_WRONG]);
        }
    }

}
