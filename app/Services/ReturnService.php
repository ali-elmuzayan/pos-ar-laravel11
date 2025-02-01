<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Models\Product;
use App\Models\Returns;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use function PHPUnit\Framework\isJson;

class ReturnService
{

    /*
     * create the return
     */
    public function createReturns($orderDetails, $quantity,Order $order)
    {
        // check if the orderDetail Able to return
        if($orderDetails->validToReturn()){
            // create the returns
            $theReturn = Returns::create([
                'total_quantity' => $quantity,
                'refund_amount' => $orderDetails->unit_cost * $quantity,
                'order_details_id' => $orderDetails->id,
                'order_id' => $order->id,
                'user_id' => Auth::user()->id
            ]);

            // change the status if the quantity is returned all
            if($orderDetails->validQtyToReturn() == $quantity) {
                $orderDetails->changeStatus();
            }

            // add the quantity to the product
            $orderDetails->addQuantityToProduct($quantity);

            // return the return entity
            return $theReturn ;
        }

        // if it not able to return return false
        return false;
    }


    /**
     * process the order process by create the order and customer if not
     * exist then create order details after that you can deposit the money
     */
    public function returnProcess(array $orderData, Order $order)
    {
        $amount = 0;
        // check the order details
        foreach($orderData as $orderDetails => $quantity) {
            $orderDetails = OrderDetails::find($orderDetails);

            if(!$orderDetails){
                return false;
            }
            $return = $this->createReturns($orderDetails, $quantity, $order);
            if ($return) {
                $amount = $amount + $return->refund_amount;
            }
            else{
                toastr()->error('حدثت مشكلة اثناء استرجاع المنتج تحقق من المرتجعات');
            }
        }

        // update the status of the order
        $order->changeStatusToReturned();


        // add the transaction
        $this->createTransaction($amount);
        return $amount;
    }


    /**
     * create the transaction and deposit to the wallet
     */
    public function createTransaction($amount) {
        $amount = ceil($amount);
       $walletTransaction = WalletTransaction::create([
            'amount' => $amount,
            'type' => 'withdraw',
            'wallet_id' => 1,
           'description' => 'عملية استرجاع',
        ]);
       $wallet = Wallet::where('id', $walletTransaction->wallet_id)->first();
       toastr()->success('تم سحب' . $amount . 'لعملية الاسترجاع');
       $wallet->withdraw($amount);
    }


    /**
     * get the data for the returns process
     */
    public function getReturnsDataFromRequest(Request $request,Order $order) {
$returnData = $request->return_quantities;

        if(!empty($returnData)) {
            $returnData = json_decode($returnData, true);
return $returnData;

        }
        toastr()->error('البيانات التي ادخلتها غير صحيحة');
        return false;
    }

}
