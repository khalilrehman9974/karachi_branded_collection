<?php

namespace App\Http\Controllers;

use App\Brand;
use App\Http\Requests\StoreBrandRequest;
use App\Services\BrandService;
use App\Services\CommonService;

class BrandsController extends Controller
{
    protected $brandService;
    protected $commonService;

    public function __construct(BrandService $brandService, CommonService $commonService)
    {
        $this->brandService = $brandService;
        $this->commonService = $commonService;
    }

    /*
     * Show page of list of brands.
     * */
    public function index()
    {
        $brands = Brand::paginate(BrandService::PER_PAGE);
        return view('brands.index', compact('brands'));
    }

    /*
     * Show page of create brand.
     * */
    public function create()
    {
        return view('brands.create');
    }

    /*
     * Save brand into db.
     * @param: @request
     * */
    public function store(StoreBrandRequest $request)
    {
        $request = $request->except('_token', 'brandId');
        $this->commonService->findUpdateOrCreate(Brand::class, ['id' => ''], $request);

        return redirect('brand/brands-list')->with('message', BrandService::BRAND_SAVED);
    }

    /*
     * Show edit page.
     * */
    public function edit($id)
    {
        $brand = Brand::find($id);
        if (empty($brand)) {
            abort(404);
        }
        return view('brands.create', compact('brand'));
    }

    /*
     * update existing resource.
     * @param: $data
     * */
    public function update(StoreBrandRequest $request)
    {
        $request = $request->except('_token', 'brandId');
        $this->commonService->findUpdateOrCreate(Brand::class, ['id' => request('brandId')], $request);

        return redirect('brand/brands-list')->with('message', BrandService::BRAND_UPDATED);
    }

    /*
     * Delete existing resource.
     * @param: request()->id
     * */
    public function delete()
    {
        $deleted = Brand::where('id', request()->id)->delete();
        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => BrandService::BRAND_DELETED]);
        } else {
            return response()->json(['status' => 'fail', 'message' => BrandService::SOME_THING_WENT_WRONG]);
        }
    }

}
