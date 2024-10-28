<?php

namespace App\Http\Controllers;

use App\Models\dokumen;
use App\Helper\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DokumenController extends Controller
{
    public function index()
    {
        if (! Gate::allows('sys_admin')) {
            abort(403);
        }
        return view('referensi.dokumen.index',[
            'data'=>dokumen::orderby('kodedokumen')->get(),
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function create()
    {
        if (! Gate::allows('sys_admin')) {
            abort(403);
        }
        return view('referensi.dokumen.create',[
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function store(Request $request)
    {
        if (! Gate::allows('sys_admin')) {
            abort(403);
        }
        $request->validate([
            'kode'=>'required|min_digits:2|max_digits:2',
            'nama'=>'required',
        ]);
        dokumen::create([
            'kodedokumen'=>$request->kode,
            'namadokumen'=>$request->nama,
            'statusdnp'=>$request->statusdnp ?? false,
            'statuspph'=>$request->statuspph ?? false,
            'statusrekanan'=>$request->statusrekanan ?? false,
            'dnp_perjadin'=>$request->dnpperjadin ?? false,
            'dnp_honor'=>$request->dnphonor ?? false,
            'blbi'=>$request->blbi ?? false,
            'realisasi'=>$request->realisasi ?? false
        ]);
        return redirect('/dokumen');
    }

    public function edit(dokumen $dokuman)
    {
        if (! Gate::allows('sys_admin')) {
            abort(403);
        }
        return view('referensi.dokumen.update',[
            'data'=>$dokuman,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function update(Request $request, dokumen $dokuman)
    {
        if (! Gate::allows('sys_admin')) {
            abort(403);
        }
        $request->validate([
            'kode'=>'required|min_digits:2|max_digits:2',
            'nama'=>'required',
        ]);

        $dokuman->update([
            'kodedokumen'=>$request->kode,
            'namadokumen'=>$request->nama,
            'statusdnp'=>$request->statusdnp ?? false,
            'statuspph'=>$request->statuspph ?? false,
            'statusrekanan'=>$request->statusrekanan ?? false,
            'dnp_perjadin'=>$request->dnpperjadin ?? false,
            'dnp_honor'=>$request->dnphonor ?? false,
            'blbi'=>$request->blbi ?? false,
            'realisasi'=>$request->realisasi ?? false
        ]);
        return redirect('/dokumen');
    }

    public function destroy(dokumen $dokuman)
    {
        if (! Gate::allows('sys_admin')) {
            abort(403);
        }
        
        $dokuman->delete();
        return redirect('/dokumen');
    }
}
