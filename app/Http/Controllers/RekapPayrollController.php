<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RekapPayrollController extends Controller
{
    public function index()
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
        }

        return view ('rekap_payroll.index', [
            'data'=>Payroll::Rekap()->paginate(15)->withQueryString(),
        ]);
    }

    public function show($norek)
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
        }
        
        return view ('rekap_payroll.detail', [
            'data'=>Payroll::where('norek', $norek)->with('tagihan')->whereHas('tagihan', function($val){
                $val->where('tahun', session()->get('tahun'));
            })->paginate(15)->withQueryString(),
        ]);
    }
}
