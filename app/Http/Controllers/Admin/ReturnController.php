<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Returns;
use App\Providers\AppServiceProvider;
use Illuminate\Http\Request;

class ReturnController extends Controller
{
    //
    public function index(){
        $returns = Returns::latest()->paginate(AppServiceProvider::PAGINATION_LIMIT);

        return view('admin.pages.returns.index', compact('returns'));
    }

    public function show(Returns $returns ){
        return view('admin.pages.returns.show', compact('returns'));
    }
}
