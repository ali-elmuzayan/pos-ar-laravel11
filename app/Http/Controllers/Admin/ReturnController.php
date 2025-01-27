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
//        $returns = Returns::latest()->paginate(AppServiceProvider::PAGINATION_LIMIT);
        $returns = Returns::all();

        return view('admin.pages.returns.index', compact('returns'));
    }

    // destroy the
    public function destroy(Request $request) {
        $return = Returns::findOrFail($request->id);
        // check if the customer has ordered before or not
            $return->delete();
            return response()->json(['success' => true, 'message' => 'تم حذف المرتجع بنجاح']);
    }

}
