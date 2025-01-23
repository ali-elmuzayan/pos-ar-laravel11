<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CategoryRequest;
use App\Http\Requests\admin\UpdateCategoryRequest;
use App\Models\Category;
use App\Models\Product;
use App\Providers\AppServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Display a listing of the Categories.
     */
    public function index()
    {
        // get all the categories
        $categories = Category::all();
        return view('admin.pages.categories.index', compact('categories'));
    }

    /**
     * show all product related to the category and have value in stock
     */
    public function show(Category $category) {
        // check if the category has products first
        if ($category->productCount() >= 1) {

            // return all valid product
            $products = $category->validProductsInStock();
            return view('admin.pages.categories.show', compact('products', 'category'));
        }

        // Notify the user and redirect to all categories
        toastr()->error('لا يوجد منتجات في هذه الفئة');
        return redirect()->route('categories.index');
    }

    /**
     * Store the category in the database
     */
    public function store(CategoryREquest $request){
        // start a database transaction
        DB::beginTransaction();

        try {
            // create the category
            Category::create($request->validated());

            // commit the transaction
            DB::commit();

            // Notify the user and Redirect to the categories index
            toastr()->success('تم انشاء فئة جديدة');
            return redirect()->route('categories.index');

        }catch (\Exception $exception){
            // Rollback the transaction in case of an error
            DB::rollback();

            // notify the user and redirect back
            toastr()->error('حدث مشكلة اثناء انشاء الفئة الجديدة');
            return redirect()->back()->withInput();
        }

    }


    /**
     * Update the specified category in storage.
     */
    public function update(UpdateCategoryRequest $request)
    {
        $category = Category::findOrFail($request->id);
        // start DB transaction
        DB::beginTransaction();
        try {
            // update the category
            $category->update([
                'name' => $request->name,
            ]);

            DB::commit();

            // Notify the user and redirect the request to all categories
            toastr()->success('تم تحديث بيانات الفئة ينجاح');
            return redirect()->route('categories.index');

        }catch (\Exception $e){
            // rollback the transaction in case of error
            DB::rollback();

            // Notify the user and redirect the request to all categories
            toastr()->error('حدثت مشكلة اثناء التحديث');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Category $category)
    {

        // check if there is no product in this category
        if($category->productCount() < 1) {
            $category->delete();
            return response()->json(['success' => true, 'message' => 'تم حذف الفئة بنجاح', 'id' => $category]);
        }
        return response()->json(['success' => false, 'message' => 'لا يمكن تحديث حذف الفئة لاحتواءه على منتجات']);
    }
}
