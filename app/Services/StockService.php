<?php


namespace App\Services;

use App\Stock;
use Illuminate\Support\Facades\DB;

class StockService
{
    public function prepareAndSaveData($request, $purchaseMasterInsert, $transactionType)
    {
        $debitQuantity = 0;
        $creditQuantity = 0;
        foreach ($request['product_id'] as $key => $value) {
            if (!empty($request['product_id'][$key])) {
                if ($transactionType == 'purchase' || $transactionType == 'sale_return') {
                    $debitQuantity = $request['quantity'][$key];
                }
                if ($transactionType == 'sale' || $transactionType == 'purchase_return') {
                    $creditQuantity = $request['quantity'][$key];
                }
                $data['invoice_id'] = $purchaseMasterInsert;
                $data['product_id'] = $request['product_id'][$key];
                $data['debit_quantity'] = $debitQuantity;
                $data['credit_quantity'] = $creditQuantity;
                $data['transaction_type'] = $transactionType;
                Stock::create($data);

            }
        }
    }

    public function getStock($request){
        $productId = isset($request["product_id"]) ? $request["product_id"] :null;
        $stock = DB::select('call prcStockReport(?)',array($productId));
        return collect($stock);
    }
}
