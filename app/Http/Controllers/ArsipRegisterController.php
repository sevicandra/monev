<?php

namespace App\Http\Controllers;

use App\Models\register;
use App\Helper\Notification;
use Illuminate\Support\Facades\Gate;

class ArsipRegisterController extends Controller
{
    public function index()
    {
        if (Gate::any(['PPSPM', 'Bendahara', 'Validator'], auth()->user()->id)) {
            return view('arsip-register.index',[
                'data'=>register::arsip()->where('tahun', session()->get('tahun'))->search()->order()->paginate(15)->withQueryString(),
                'notifikasi'=>Notification::Notif()
            ]);
        }

        return view('arsip-register.index',[
            'data'=>register::registerppk()->arsip()->where('tahun', session()->get('tahun'))->search()->order()->paginate(15)->withQueryString(),
            'notifikasi'=>Notification::Notif()
        ]);
    }
}
