<?php

namespace App\Http\Controllers;

use App\Models\bulan;
use App\Helper\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BulanController extends Controller
{

    public function index()
    {
        if (! Gate::allows('sys_admin')) {
            abort(403);
        }
        return view('referensi.bulan.index',[
            'data'=>bulan::orderby('kodebulan')->get(),
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function create()
    {
        if (! Gate::allows('sys_admin')) {
            abort(403);
        }
        return view('referensi.bulan.create',[
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function store(Request $request)
    {
        if (! Gate::allows('sys_admin')) {
            abort(403);
        }
        $request->validate([
            'kodebulan'=>'unique|required|min:2|max:2',
            'kodebulan'=>'numeric',
            'namabulan'=>'required'
        ]);

        bulan::create([
            'kodebulan'=>$request->kodebulan,
            'namabulan'=>$request->namabulan,
        ]);

        return redirect('/bulan');
    }

    public function edit(bulan $bulan)
    {
        if (! Gate::allows('sys_admin')) {
            abort(403);
        }
        return view('referensi.bulan.update',[
            'data'=>$bulan,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function update(Request $request, bulan $bulan)
    {
        if (! Gate::allows('sys_admin')) {
            abort(403);
        }
        $request->validate([
            'kodebulan'=>'unique|required|min:2|max:2',
            'kodebulan'=>'numeric',
            'namabulan'=>'required'
        ]);

        $bulan->update([
            'kodebulan'=>$request->kodebulan,
            'namabulan'=>$request->namabulan,
        ]);

        return redirect('/bulan');
    }

    public function destroy(bulan $bulan)
    {
        if (! Gate::allows('sys_admin')) {
            abort(403);
        }
        $bulan->delete();
        return redirect('/bulan');
    }
}
