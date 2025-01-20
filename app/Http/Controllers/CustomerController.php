<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\CustomerRequest;
use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    // show all customers
    public function index() {
        $customers = Customer::orderBy('id', 'desc')->get();
        return view('admin.pages.customers.index', compact('customers'));
    }


    // show the edit form of the customer
    public function edit(Customer $customer) {

        return view('admin.pages.customers.edit', compact('customer'));
    }

    // update the form of the customer
    public function update(CustomerRequest $request, Customer $customer) {
$customer->update($request->validated());
return redirect()->route('customers.index')->with('success', 'تم تعديل بيانات العميل');
    }
}
