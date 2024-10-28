<?php

namespace App\Http\Controllers\Auditor;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\tahun;

class AuditorSessionController extends Controller
{
    public function tahun_anggaran(Request $request)
    {
        if ($request->tahun) {
            $request->session()->put('tahun', $request->tahun);
            return redirect('/audit');
        }

        return view('audit.session.tahun_anggaran',[
            'tahun'=>tahun::orderBy('tahun', 'desc')->get(),
        ]);
    }  
}
