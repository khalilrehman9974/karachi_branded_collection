<?php

namespace App\Http\Controllers;

use App\Account;
use App\AccountLedger;
use App\Brand;
use App\Category;
use App\Http\Requests\StorePurchaseReturnRequest;
use App\Party;
use App\Product;
use App\PurchaseReturnDetail;
use App\PurchaseReturnMaster;
use App\Services\AccountLedgerService;
use App\Services\CommonService;
use App\Services\ProductService;
use App\Services\PurchaseReturnService;
use App\Services\StockService;
use App\Stock;
use Illuminate\Support\Facades\DB;

class PurchaseReturnController extends Controller
{
    protected $productService;
    protected $commonService;
    protected $purchaseReturnService;
    protected $stockService;
    protected $accountLedgerService;

    public function __construct(ProductService $productService, CommonService $commonService, PurchaseReturnService $purchaseReturnService, StockService $stockService, AccountLedgerService $accountLedgerService)
    {
        $this->commonService = $commonService;
        $this->productService = $productService;
        $this->purchaseReturnService = $purchaseReturnService;
        $this->stockService = $stockService;
        $this->accountLedgerService = $accountLedgerService;
    }

    /*
     * Show page of list of purchases return.
     * */
    public function index()
    {
        $request = request()->all();
        $purchaseReturn = $this->purchaseReturnService->searchPurchaseReturn($request);
        return view('purchase_return.index', compact('purchaseReturn', 'request'));
    }

    /*
     * Show page of create purchase return.
     * */
    public function create()
    {
        $brands = Brand::pluck('name', 'id');
        $products = Product::pluck('name', 'id');
        $parties = Account::where('account_type', 'P')->pluck('name', 'account_code');

        return view('purchase_return.create', compact('brands',  'products', 'parties'));
    }

    /*
     * Save purchase return into db.
     * @param: @request
     * */
    public function store(StorePurchaseReturnRequest $request)
    {
        $request = $request->except('_token', 'purchaseReturnId');
        try {
            DB::beginTransaction();
            //Insert data into purchase tables.
            $purchaseMasterData = $this->purchaseReturnService->preparePurchaseReturnMasterData($request);
            $purchaseMasterInsert = $this->commonService->findUpdateOrCreate(PurchaseReturnMaster::class, ['id' => ''], $purchaseMasterData);
            $purchaseDetailData = $this->purchaseReturnService->preparePurchaseReturnDetailData($request, $purchaseMasterInsert->id);
            $this->purchaseReturnService->savePurchaseReturn($purchaseDetailData);
            //Insert data into stock table.
            $this->stockService->prepareAndSaveData($request, $purchaseMasterInsert->id, PurchaseReturnService::PURCHASE_RETURN_TRANSACTION_TYPE);
            //Insert data into accounts ledger table.
            $debitAccountData = $this->purchaseReturnService->prepareAccountCreditData($request, $purchaseMasterInsert->id, PurchaseReturnService::PURCHASE_RETURN_TRANSACTION_TYPE, PurchaseReturnService::PURCHASE_RETURN_DESCRIPTION);
            $creditAccountData = $this->purchaseReturnService->prepareAccountDebitData($request, $purchaseMasterInsert->id, PurchaseReturnService::PURCHASE_RETURN_TRANSACTION_TYPE, PurchaseReturnService::PURCHASE_RETURN_DESCRIPTION);
            AccountLedger::insert($debitAccountData);
            AccountLedger::insert($creditAccountData);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('purchase-return/create')->with('error', $e->getMessage());
        }
        return redirect('purchase-return/purchase-return-list')->with('message', PurchaseReturnService::PURCHASE_RETURN_SAVED);
    }

    /*
     * Show edit page.
     * */
    public function edit($id)
    {
        $brands = Brand::pluck('name', 'id');
        $purchaseReturn = PurchaseReturnMaster::find($id);
        $products = Product::where('brand_id', $purchaseReturn->brand_id)->pluck('name', 'id');
        $parties = Party::pluck('name', 'id');
        $purchaseReturnDetails = PurchaseReturnDetail::where('purchase_master_id', $id)->get();
        if (empty($purchase)) {
            abort(404);
        }

        return view('purchase_return.create', compact('purchaseReturn', 'brands', 'products', 'parties', 'purchaseReturnDetails'));
    }

    /*
     * update existing resource.
     * @param: $data
     * */
    public function update(StorePurchaseReturnRequest $request)
    {
        try {
            DB::beginTransaction();
            $request = request()->all();
            PurchaseReturnMaster::where('id', $request['purchaseReturnId'])->delete();
            PurchaseReturnDetail::where('purchase_return_master_id', $request['purchaseReturnId'])->delete();
            Stock::where('invoice_id', $request['purchaseReturnId'])->delete();
            AccountLedger::where('invoice_id', $request['purchaseReturnId'])->delete();

            //Save data into relevant tables.
            $purchaseMasterData = $this->purchaseReturnService->preparePurchaseMasterData($request);
            $purchaseMasterInsert = $this->commonService->findUpdateOrCreate(PurchaseReturnMaster::class, ['id' => request('productId')], $purchaseMasterData);
            $purchaseDetailData = $this->purchaseReturnService->preparePurchaseDetailData($request, $purchaseMasterInsert->id);
            $this->purchaseReturnService->savePurchase($purchaseDetailData);
            //Save data into stock table.
            $this->stockService->prepareAndSaveData($request, $purchaseMasterInsert->id, PurchaseReturnService::PURCHASE_RETURN_TRANSACTION_TYPE);
            $debitAccountData = $this->purchaseReturnService->prepareAccountCreditData($request, $purchaseMasterInsert->id, PurchaseReturnService::PURCHASE_RETURN_TRANSACTION_TYPE, PurchaseReturnService::PURCHASE_RETURN_DESCRIPTION);
            $creditAccountData = $this->purchaseReturnService->prepareAccountDebitData($request, $purchaseMasterInsert->id, PurchaseReturnService::PURCHASE_RETURN_TRANSACTION_TYPE, PurchaseReturnService::PURCHASE_RETURN_DESCRIPTION);
            AccountLedger::insert($debitAccountData);
            AccountLedger::insert($creditAccountData);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('purchase-return/create')->with('error', $e->getMessage());
        }

        return redirect('purchase-return/purchase-return-list')->with('message', PurchaseReturnService::PURCHASE_RETURN_UPDATED);
    }

    /*
     * Delete existing resource.
     * @param: request()->id
     * */
    public function delete()
    {
        try {
            DB::beginTransaction();
            $deleteMaster = PurchaseReturnMaster::where('id', request()->id)->delete();
            $deleteDetail = PurchaseReturnDetail::where('purchase_return_master_id', request()->id)->delete();
            $deleteStock = Stock::where('invoice_id', request()->id)->delete();
            $accountEntryDetail = AccountLedger::where('invoice_id', request()->id)->delete();
            DB::commit();
            if ($deleteMaster && $deleteDetail && $deleteStock && $accountEntryDetail) {
                return response()->json(['status' => 'success', 'message' => PurchaseReturnService::PURCHASE_RETURN_DELETED]);
            } else {
                return response()->json(['status' => 'fail', 'message' => PurchaseReturnService::SOME_THING_WENT_WRONG]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return redirect('purchase-return/purchase-return-list')->with('error', $e->getMessage());
        }
    }

    /*
    * View Purchase return detail.
    * @param: $id
    * */
    public function view($id)
    {
        $purchaseReturnMaster = $this->purchaseReturnService->getPurchaseReturnMasterById($id);
        $purchaseReturnDetail = $this->purchaseReturnService->getPurchaseReturnDetailById($id);
        if (empty($purchaseReturnMaster)) {
            abort(404);
        }

        return view('purchase_return.view', compact('purchaseReturnMaster', 'purchaseReturnDetail'));
    }

    /*
     * Get list of products by brand and category.
     * @param: Request $request
     * */
    public function getProductsByBrand()
    {
        $products = $this->purchaseReturnService->getProductsByCategoryBrand(request()->all());
        if ($products) {
            return json_encode(['status' => 'success', 'data' => $products]);
        } else {
            return response()->json(['status' => 'fail', 'message' => PurchaseReturnService::SOME_THING_WENT_WRONG]);
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
            return response()->json(['status' => 'fail', 'message' => PurchaseReturnService::SOME_THING_WENT_WRONG]);
        }
    }
}
