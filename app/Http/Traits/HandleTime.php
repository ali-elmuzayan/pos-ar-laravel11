<?php

namespace App\Http\Traits;

use DateTime;

trait HandleTime
{

    public function getTime($time, $format = 'Y-m-d H:i:s') {
        $dt = new DateTime($time);
        return $dt->format($format);
    }
}
