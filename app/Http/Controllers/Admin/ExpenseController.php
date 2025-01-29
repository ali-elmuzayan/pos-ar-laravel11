<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExpenseRequest;
use App\Models\Expense;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ExpenseController extends Controller
{

    /**
     * show a list of expenses, create form, and edit form
     */
    public function index() {
        // show the total amount of expenses in the current month
        $total = (int) Expense::totalExpenseForCurrentMonth();

        // return all the expenses of the month
        $expenses = Expense::ExpensesInCurrentMonth();
        return view('admin.pages.expenses.index', compact('expenses', 'total'));
    }


    /**
     * store the expense in the storage
     */
    public function store(ExpenseRequest $request) {
        // Start transaction
        DB::beginTransaction();
        try {

            // check if the main account has balance
            $mainWallet = Wallet::where('id','=', '2')->first();
                $amount = $request->amount;

            if($mainWallet->hasBalance($amount)){
                $description = $request->details;

                $mainWallet->withdraw($amount);
                WalletTransaction::create([
                    'wallet_id' => $mainWallet->id,
                    'amount' => $amount,
                    'type' => 'withdraw',
                    'description' => $description,
                ]);
            Expense::create([
                'details' => $description,
                'amount' => $amount,
                'date' => Carbon::now(),
            ]);

                // create the expense

                DB::commit();

                // Notify the user && redirect the request
                toastr()->success('تم انشاء النفقة بنجاح');
                return redirect()->route('expenses.index');
            }
            DB::rollBack();
            toastr()->error('لا يوجد رصيد في الحساب الرئيسي');
            return redirect()->route('expenses.index');

        } catch(\Exception $e) {
            // rollback the transaction
            DB::rollBack();

            // Notify the user && redirect to the request
            toastr()->error('حدث خطأ اثناء انشاء النفقة');
            return redirect()->route('expenses.index');
        }
    }

    /**
     * Update the specified expense in storage
     */
    public function update(ExpenseRequest $request,Expense $expense) {
        // start the transaction
        DB::beginTransaction();

        try {
            // update the data
            $expense->update([
                'details' => $request->details,
                'amount' => $request->amount,
            ]);

            // commit the changes
            DB::commit();

            // Notify the user and redirect to the expenses index
            toastr()->success('تم تحديث بيانات النفقة بنجاح');
            return redirect()->route('expenses.index');
        }
        catch (\Exception $e) {
            // rollback the transaction
            DB::rollBack();

            // Notify the use to the error and redirect to the list of expenses
            toastr()->error('حدث مشكلة اثناء التحديث');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(Expense $expense)
    {
            $expense->delete();
            return response()->json(['success' => true, 'message' => 'تم حذف النفقة رقم'. $expense->id .' بنجاح', 'id' => $expense]);

    }
}
