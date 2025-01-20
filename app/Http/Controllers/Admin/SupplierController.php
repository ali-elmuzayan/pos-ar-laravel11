<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use App\Providers\AppServiceProvider;
use Illuminate\Http\Request;

class SupplierController extends Controller
{

    // show all supplier with the create and edit form
    public function index() {
        $suppliers = Supplier::latest()->paginate(AppServiceProvider::PAGINATION_LIMIT);
        return view('admin.pages.suppliers.index', compact('suppliers'));
    }

    public function store(SupplierRequest $request) {
dd($request->all());
    }

    public function update(SupplierRequest $request, Supplier $supplier) {
        dd($request->all());

        return redirect()->route('admin.pages.suppliers.index');
    }
}
