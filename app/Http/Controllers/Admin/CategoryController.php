<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\admin\CategoryRequest;
use App\Http\Requests\admin\UpdateCategoryRequest;
use App\Models\Category;
use App\Providers\AppServiceProvider;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Category::all();
        return view('admin.pages.categories.index', compact('data'));
    }



    /**
     * Display the specified resource.
     */
    public function store(CategoryRequest $request)
    {

        Category::create($request->all());
        return redirect()->route('categories.index');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request)
    {


        $category = Category::find($request->id);
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->route('categories.index')->with('success', 'تم تحديث الفئة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

        $category->delete();
        return response()->json(['success' => true, 'message' => '', 'id' => $category]);

//
    }
}
