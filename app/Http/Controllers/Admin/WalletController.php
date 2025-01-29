<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WalletController extends Controller
{
    public  function index() {
        $wallets = Wallet::all();
        $walletTransactions = WalletTransaction::latest()->limit(50)->get();



        return view('admin.pages.wallets.index', compact('wallets', 'walletTransactions'));
    }


    public function withdraw(Request $request, $id) {
        $wallet = Wallet::where('id', '=', $id)->first();
        if(!empty($wallet)) {
            $amount = $request->amount;
            DB::beginTransaction();

            if($wallet->hasBalance($amount)) {
                $wallet->withdraw($amount);
               $transaction =  WalletTransaction::create([
                    'wallet_id' => $id,
                    'amount' => $amount,
                    'type' => 'withdraw',
                    'description' => $request->description
                ]);
                DB::commit();
            }
            else {
                DB::rollback();

        return response()->json(['error' => true, 'message' => 'لا يوجد مبلغ كافي في المحفظة للسحب ']);
            }
        return response()->json(['success' => true, 'message' => 'تمت السحب بنجاح ', 'new_balance' => $wallet->balance, 'transaction' => [
            'id' => $transaction->id,
            'amount' => $transaction->amount,
            'wallet_name' => $wallet->name,
            'type' => $transaction->type,
            'description' => $transaction->description,
        ],]);
        }

        DB::rollBack();
        return response()->json(['error' => true, 'message' => 'المحفظة التي ادخلت غير صحيحة او هناك مشكلة بها']);


    }


    /**
     * Withdraw to the main account
     */

    public function withdrawToMain(Request $request, $id) {
       $wallet = Wallet::where('id', '=', $id)->first();
       $mainWallet = Wallet::where('id', '=', 2)->first();

       if($wallet->balance <= 0) {
           toastr()->error('المحفظة فارغة لا يمكن التحويل الى الحساب الرئيسي');
           return redirect()->route('wallets.index');
       }
       DB::beginTransaction();
       try{
           // سحب من الكاشير الى الحساب الرئيسي
           $walletBalance = $wallet->balance;
       $wallet->withdraw($wallet->balance);
       WalletTransaction::create([
           'wallet_id' => $wallet->id,
           'amount' => $walletBalance,
           'type' => 'withdraw',
           'description' => 'تفريغ المال من الكاشير'
       ]);

       $mainWallet->deposit($walletBalance);
       WalletTransaction::create([
           'wallet_id' => $mainWallet->id,
           'amount' => $walletBalance,
           'type' => 'deposit',
           'description' => 'ايداع الاموال الموجودة في  الكاشير الى الخزنة الرئيسية',
       ]);

       // commit
       DB::commit();

       //Notify the user
       toastr()->success('تم تفريغ خزنة الكاشير الى الحساب الرئيسي');
       return redirect()->route('wallets.index');
       }catch(\Exception $ex) {
           DB::rollback();
           toastr()->error('حدث خطأ اثناء التحويل الى الحساب الرئيسي');
           return redirect()->route('wallets.index');
       }

    }

    public function deposit(Request $request, $id) {
        $wallet = Wallet::where('id', '=', $id)->first();
        if(!empty($wallet)) {
            $amount = $request->amount;
            DB::beginTransaction();

            // add the amount to the wallet
            $wallet->deposit($amount);
            $transaction = WalletTransaction::create([
                'wallet_id' => $id,
                'amount' => $amount,
                'type' => 'deposit',
                'description' => $request->description
            ]);
            DB::commit();

            return response()->json(['success' => true, 'message' => 'تمت السحب بنجاح ', 'new_balance' => $wallet->balance, 'transaction' => [
                'id' => $transaction->id,
                'amount' => $transaction->amount,
                'wallet_name' => $wallet->name,
                'type' => $transaction->type,
                'description' => $transaction->description,
            ],]);
        }

        DB::rollBack();
        return response()->json(['error' => true, 'message' => 'المحفظة التي ادخلت غير صحيحة او هناك مشكلة بها']);

    }


    public function getTransactions($id) {
        $wallet = Wallet::findOrFail($id);

        // Fetch transactions for this wallet
        $transactions = $wallet->transactions()->orderBy('created_at', 'desc')->limit(50)->get();

        return response()->json([
            'success' => true,
            'transactions' => $transactions->map(function ($transaction) {
                return [
                    'id' => $transaction->id,
                    'amount' => $transaction->amount,
                    'wallet_name' => $transaction->wallet->name,
                    'type' => $transaction->type,
                    'description' => $transaction->description,
                ];
            }),
        ]);
    }
}
