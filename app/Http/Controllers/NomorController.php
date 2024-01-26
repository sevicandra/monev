<?php

namespace App\Http\Controllers;

use App\Models\nomor;
use App\Helper\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class NomorController extends Controller
{

    public function index()
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }

        return view('referensi.nomor.index',[
            'data'=>nomor::search()->paginate(15)->withQueryString(),
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function create()
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        
        return view('referensi.nomor.create',[
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function store(Request $request)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }

        $request->validate([
            'nomor'=>'required|numeric',
            'tahun'=>'required|min:4|max:4',
            'kodesatker'=>'required|min:6|max:6'
        ]);

        $request->validate([
            'kodesatker'=>'numeric',
            'tahun'=>'numeric',
        ]);

        nomor::create([
            'nomor'=>$request->nomor,
            'ekstensi'=>'/'.$request->kodesatker.'/',
            'kodesatker'=>$request->kodesatker,
            'tahun'=>$request->tahun,
        ]);

        return redirect('/nomor');
    }

    public function edit(nomor $nomor)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }

        return view('referensi.nomor.update',[
            'data'=>$nomor,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function update(Request $request, nomor $nomor)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }

        $request->validate([
            'nomor'=>'required|numeric'
        ]);

        $nomor->update([
            'nomor'=>$request->nomor
        ]);
        return redirect('/nomor');
    }

    public function destroy(nomor $nomor)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        
        $nomor->delete();
        return redirect('/nomor');
    }
}
