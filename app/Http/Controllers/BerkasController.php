<?php

namespace App\Http\Controllers;

use App\Models\berkas;
use App\Helper\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BerkasController extends Controller
{
    public function index()
    {
        if (! Gate::allows('sys_admin')) {
            abort(403);
        }
        return view('referensi.berkas.index',[
            'data'=>berkas::orderby('kodeberkas')->get(),
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function create()
    {
        if (! Gate::allows('sys_admin')) {
            abort(403);
        }
        return view('referensi.berkas.create',[
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function store(Request $request)
    {
        if (! Gate::allows('sys_admin')) {
            abort(403);
        }
        $request->validate([
            'kode'=>'required|unique|min:2|max:2',
            'kode'=>'numeric',
            'berkas'=>'required|'
        ]);

        berkas::create([
            'kodeberkas'=>$request->kode,
            'namaberkas'=>$request->berkas
        ]);

        return redirect('/berkas');
    }

    public function edit(berkas $berka)
    {
        if (! Gate::allows('sys_admin')) {
            abort(403);
        }
        return view('referensi.berkas.update',[
            'data'=>$berka,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function update(Request $request, berkas $berka)
    {
        if (! Gate::allows('sys_admin')) {
            abort(403);
        }
        $request->validate([
            'kode'=>'required|min:2|max:2',
            'kode'=>'numeric',
            'berkas'=>'required|'
        ]);

        $berka->update([
            'kodeberkas'=>$request->kode,
            'namaberkas'=>$request->berkas
        ]);

        return redirect('/berkas');
    }

    public function destroy(berkas $berka)
    {
        if (! Gate::allows('sys_admin')) {
            abort(403);
        }
        $berka->delete();
        return redirect('/berkas');
    }
}
