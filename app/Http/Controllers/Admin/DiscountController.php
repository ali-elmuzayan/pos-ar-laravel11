<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DiscountRequest;
use App\Models\Discount;
use Illuminate\Http\Request;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $discounts = Discount::all();
        return view('admin.pages.discounts.index', compact('discounts'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DiscountRequest $request)
    {
        dd($request->all());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DiscountRequest $request, Discount $discount)
    {
        dd($request->all());
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return response()->json(['success' => true, 'message' => 'تم حذف الخصم رقم'. $discount->id .' بنجاح', 'id' => $discount]);

    }

}
