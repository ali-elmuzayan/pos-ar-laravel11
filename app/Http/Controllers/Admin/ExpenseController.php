<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ExpenseRequest;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{

    // show the expense page
    public function index() {
        $total = (int) Expense::totalExpenseForCurrentMonth();
        $data = Expense::ExpensesInCurrentMonth();
        return view('admin.pages.expenses.index', compact('data', 'total'));
    }

    public function store(ExpenseRequest $request) {

        Expense::create([
            'details' => $request->details,
            'amount' => $request->amount,
            'date' => Carbon::now(),
            ]);

        return redirect()->route('expenses.index');
    }

    public function update(ExpenseRequest $request,Expense $expense) {

        $expense->update([
            'details' => $request->details,
            'amount' => $request->amount,
        ]);

        return redirect()->route('expenses.index');
    }
}
