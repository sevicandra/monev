<?php

namespace App\Http\Controllers;

use App\Models\register;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;

class ArsipRegisterController extends Controller
{
    public function index()
    {
        if (Gate::any(['PPSPM', 'Bendahara', 'Validator'], auth()->user()->id)) {
            return view('arsip-register.index',[
                'data'=>register::arsip()->where('tahun', session()->get('tahun'))->search()->order()->paginate(15)->withQueryString()
            ]);
        }

        return view('arsip-register.index',[
            'data'=>register::registerppk()->arsip()->where('tahun', session()->get('tahun'))->search()->order()->paginate(15)->withQueryString()
        ]);
    }
}