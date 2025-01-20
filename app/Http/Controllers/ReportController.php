<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\Report\Xml\Report;

class ReportController extends Controller
{


    public function orders()
    {
        $data = Product::all();
        return view('admin.pages.reports.orders', compact('data'));
    }


}
