<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Category;
use App\Http\Requests\StoreProductRequest;
use App\Product;
use App\Services\CommonService;
use App\Services\ProductService;

class ProductsController extends Controller
{
    protected $productService;
    protected $commonService;

    public function __construct(ProductService $productService, CommonService $commonService)
    {
        $this->commonService = $commonService;
        $this->productService = $productService;
    }

    /*
     * Show page of list of products.
     * */
    public function index()
    {
        $request = request()->all();
        $products = $this->productService->searchProduct($request);

        return view('products.index', compact('products', 'request'));
    }

    /*
     * Show page of create product.
     * */
    public function create()
    {
        $brands = Brand::pluck('name','id');
        $categories = Category::pluck('name','id');

        return view('products.create', compact('brands','categories'));
    }

    /*
     * Save products into db.
     * @param: @request
     * */
    public function store(StoreProductRequest $request)
    {
        $request = $request->except('_token', 'productId');
        $this->commonService->findUpdateOrCreate(Product::class, ['id' => ''], $request);

        return redirect('product/products-list')->with('message', ProductService::PRODUCT_SAVED);
    }

    /*
     * Show edit page.
     * */
    public function edit($id)
    {
        $brands = Brand::pluck('name','id');
        $categories = Category::pluck('name','id');
        $product = Product::find($id);
        if (empty($product)) {
            abort(404);
        }
        return view('products.create', compact('product', 'brands','categories'));
    }

    /*
     * update existing resource.
     * @param: $data
     * */
    public function update(StoreProductRequest $request)
    {
        $request = $request->except('_token', 'productId');
        $this->commonService->findUpdateOrCreate(Product::class, ['id' => request('productId')], $request);

        return redirect('product/products-list')->with('message', ProductService::PRODUCT_UPDATED);
    }

    /*
     * Delete existing resource.
     * @param: request()->id
     * */
    public function delete()
    {
        $deleted = Product::where('id', request()->id)->delete();
        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => ProductService::PRODUCT_DELETED]);
        } else {
            return response()->json(['status' => 'fail', 'message' => ProductService::SOME_THING_WENT_WRONG]);
        }
    }

    /*
    * View Product detail.
    * @param: $id
    * */
    public function view($id){
        $product = $this->productService->getById($id);
        if(empty($product)){
            abort(404);
        }

        return view('products.view', compact('product'));
    }
}
