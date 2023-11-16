<?php

namespace App\Http\Controllers;

use App\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Services\CategoryService;
use App\Services\CommonService;

class CategoriesController extends Controller
{
    protected $categoryService;
    protected $commonService;

    public function __construct(CategoryService $categoryService, CommonService $commonService)
    {
        $this->categoryService = $categoryService;
        $this->commonService = $commonService;
    }

    /*
     * Show page of list of categories.
     * */
    public function index()
    {
        $categories = Category::paginate(CategoryService::PER_PAGE);
        return view('categories.index', compact('categories'));
    }

    /*
     * Show page of create category.
     * */
    public function create()
    {
        return view('categories.create');
    }

    /*
     * Save category into db.
     * @param: @request
     * */
    public function store(StoreCategoryRequest $request)
    {
        $request = $request->except('_token', 'categoryId');
        $this->commonService->findUpdateOrCreate(Category::class, ['id' => ''], $request);

        return redirect('category/categories-list')->with('message', CategoryService::CATEGORY_SAVED);
    }

    /*
     * Show edit page.
     * */
    public function edit($id)
    {
        $category = Category::find($id);
        if (empty($category)) {
            abort(404);
        }
        return view('categories.create', compact('category'));
    }

    /*
     * update existing resource.
     * @param: $data
     * */
    public function update(StoreCategoryRequest $request)
    {
        $request = $request->except('_token', 'categoryId');
        $this->commonService->findUpdateOrCreate(Category::class, ['id' => request('categoryId')], $request);

        return redirect('category/categories-list')->with('message', CategoryService::CATEGORY_UPDATED);
    }

    /*
     * Delete existing resource.
     * @param: request()->id
     * */
    public function delete()
    {
        $deleted = Category::where('id', request()->id)->delete();
        if ($deleted) {
            return response()->json(['status' => 'success', 'message' => CategoryService::CATEGORY_DELETED]);
        } else {
            return response()->json(['status' => 'fail', 'message' => CategoryService::SOME_THING_WENT_WRONG]);
        }
    }
}
