<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\updateSupplierRequest;
use App\Http\Requests\SupplierRequest;
use App\Http\Traits\handleImage;
use App\Models\Supplier;
use App\Providers\AppServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SupplierController extends Controller
{
    use handleImage;

    // show all supplier with the create and edit form
    public function index() {
        $suppliers = Supplier::latest()->paginate(AppServiceProvider::PAGINATION_LIMIT);
        return view('admin.pages.suppliers.index', compact('suppliers'));
    }

    public function store(SupplierRequest $request) {
        DB::beginTransaction();
        try {
            $imagePath = null;
            // Handle image upload if present
            if ($request->hasFile('image')) {
                // Upload the new image
                $imagePath = $this->uploadImage($request->file('image'), 'uploads/users');
            }
            Supplier::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email ?? null,
                'address' => $request->address ?? null,
                'image' => $imagePath,
            ]);
            DB::commit();
            toastr()->success('تم اضافى موزع جديد');
            return redirect()->route('suppliers.index');

        }catch (\Exception $exception){
            DB::rollBack();

            // Notify and redirect
            toastr()->error('حدث مشكلة اثناء اضافى الموزع يرجى المحالة مرة ثانية');
            return redirect()->route('suppliers.index');

        }
    }



    public function update(updateSupplierRequest $request, Supplier $supplier) {

        DB::beginTransaction();
        try {
            // Handle image upload if present
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($supplier->image && Storage::exists($supplier->image)) {
                    Storage::delete($supplier->image);
                }

                // Upload the new image
                $imagePath = $this->upload($request->file('image'), 'uploads/users');
                $supplier->image = $imagePath;
            }
            $supplier->update($request->except('image'));

            DB::commit();
            toastr()->success('تم تعديل بيانات الموزع بنجاح');
            return redirect()->route('suppliers.index');

        }catch (\Exception $exception){
            DB::rollBack();

            toastr()->error('حدث مشكلة اثناء تحديث بيانات المزوع');
            return redirect()->route('suppliers.index');
        }

    }

    public function destroy(Request $request) {
        $supplier = Supplier::findOrFail($request->id);
        $name = $supplier->name;
        if($supplier->countOfProducts() < 1) {
            $supplier->delete();
            return response()->json(['success' => true, 'message' =>  "تم حذف الموزع " .$name ." بنجاح"]);
        }else {
        return response()->json(['error' => true, 'message' => 'لا يمكن حذف الموزع في حالة وجود منتجات خاصة به']);
        }

    }
}
