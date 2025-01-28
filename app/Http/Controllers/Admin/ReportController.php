<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class ReportController extends Controller
{


    public function orders()
    {
        $data = Product::all();
        return view('admin.pages.reports.orders', compact('data'));
    }


}
