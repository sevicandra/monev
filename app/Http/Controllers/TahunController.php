<?php

namespace App\Http\Controllers;

use App\Models\tahun;
use App\Helper\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TahunController extends Controller
{
    public function index()
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.tahun.index',[
            'data'=>tahun::orderby('tahun')->get(),
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function create()
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.tahun.create',[
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function store(Request $request)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $request->validate([
            'tahun'=>'required|numeric|min:2020'
        ]);

        tahun::create([
            'tahun'=>$request->tahun
        ]);

        return redirect('/tahun');
    }

    public function show(tahun $tahun)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        //
    }

    public function edit(tahun $tahun)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.tahun.update',[
            'data'=>$tahun,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function update(Request $request, tahun $tahun)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $request->validate([
            'tahun'=>'required|numeric|min:2020'
        ]);

        $tahun->update([
            'tahun'=>$request->tahun
        ]);

        return redirect('/tahun');
    }

    public function destroy(tahun $tahun)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $tahun->delete();
    }
}
