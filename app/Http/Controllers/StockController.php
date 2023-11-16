<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\CommonService;
use App\Services\StockService;
use Illuminate\Http\Request;

class StockController extends Controller
{
    protected $commonService;
    protected $stockService;

    public function __construct(CommonService $commonService, StockService $stockService)
    {
        $this->commonService = $commonService;
        $this->stockService = $stockService;
    }

    public function index(){
        $request = [];
        $products = $this->commonService->vouchersDropDownData();
        $stockData = $this->stockService->getStock($request);
//        dd($stockData);
        return view('reports.stock', compact('products', 'stockData'));
    }

    public function view(){
        $products = $this->commonService->vouchersDropDownData();
        $stockData = $this->stockService->getStock(request()->all());
        return view('reports.stock', compact('products', 'stockData'));
    }
}


