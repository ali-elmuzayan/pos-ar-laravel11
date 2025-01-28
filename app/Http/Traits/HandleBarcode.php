<?php

namespace App\Http\Traits;

trait HandleBarcode
{
    public function generateCode($lastItemCode) {
        // this format is fixed for all the barcodes
        $date =  now()->format('ym') . '00';

        // check if it not empty
        if (!empty($lastItemCode)) {

            // get the last 4 digit of the code
            $last4Digits = substr($lastItemCode, -4);

            // when it less than 9999 add one otherwise start again
            if ($last4Digits < '9999') {
                $last4Digits++;
                return  $date . $last4Digits  ;
            } else {
                return  $date . '001';
            }
        }

        // if the last item code is empty that mean it is the first code
        return  $date . '1';
    }
}
