<?php

namespace App\Http\Controllers;

use App\Models\spm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SP2DController extends Controller
{
    public function index()
    {
        if (! Gate::any(['sys_admin', 'admin_satker'], auth()->user()->id)) {
            abort(403);
        }
        return view("data_cleansing.SP2D.index",[
            "data"=> spm::duplicate()->get(),
        ]);
    }

    public function delete(spm $spm)
    {
        if (! Gate::any(['sys_admin', 'admin_satker'], auth()->user()->id)) {
            abort(403);
        }

        if($spm->tagihan->kodesatker != auth()->user()->satker){
            abort(403);
        };

        $spm->delete();
        return redirect('/cleansing/sp2d')->with("berhasil","Data Berhasilah Dihapus");
    }
}
