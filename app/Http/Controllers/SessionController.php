<?php

namespace App\Http\Controllers;

use App\Models\tahun;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function tahun_anggaran(Request $request)
    {
        if ($request->tahun) {
            $request->session()->put('tahun', $request->tahun);
        }
        
        return view('session.tahun_anggaran',[
            'tahun'=>tahun::all()
        ]);
    }

}
