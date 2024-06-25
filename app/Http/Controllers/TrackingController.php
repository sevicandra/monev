<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\tagihan;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    public function index()
    {
        return view('tracking.index',[
            'data'=>Payroll::Tracking()->paginate(15)->withQueryString(),
        ]);
    }

    public function tracking(Request $request)
    {
        $tagihan = tagihan::find($request->tagihan_id);
        if ($tagihan) {
            return view('tracking.tracking',[
                'data' => $tagihan->log()->orderby('created_at', 'ASC')->get(),
            ]);
        } else {
            abort(404);
        }
    }
}
