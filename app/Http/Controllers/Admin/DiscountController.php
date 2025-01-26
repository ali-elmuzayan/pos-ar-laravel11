<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\DiscountRequest;
use App\Models\Discount;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $counter = 1;
        $discounts = Discount::all();
        return view('admin.pages.discounts.index', compact('discounts', 'counter'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(DiscountRequest $request)
    {
        // Convert the date to MySQL format (YYYY-MM-DD)
//        if(!empty($request->end_date)){
//        $endDate = Carbon::createFromFormat('m/d/Y g:i A', $request->end_date)->toDateString();
//        }

       // Insert into the database
        Discount::create([
            'percent' => $request->percent,
            'end_date' => $request->end_date,
        ]);
        toastr()->success('تم انشاء خصم جديد بنجاح');
        return redirect()->route('discounts.index');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(DiscountRequest $request, Discount $discount)
    {
        DB::beginTransaction();
        try {

            // update the discount data and commit
            $discount->update([
                'percent' => $request->percent,
                'end_date' => $request->end_date,
            ]);
            DB::commit();

            // Notify the user and redirect to the discounts
            toastr()->success('تم تعديل الخصم بنجاح');
            return redirect()->route('discounts.index');
        }catch (\Exception $exception){
            DB::rollBack();

            // Notify the user with error and redirect to the discounts
            toastr()->error('حدث خطأ اثناء التحديث');
            return redirect()->route('discounts.index');
        }


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
