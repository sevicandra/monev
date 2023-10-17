<?php

namespace App\Http\Controllers;

use App\Models\dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class DokumenController extends Controller
{
    public function index()
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.dokumen.index',[
            'data'=>dokumen::orderby('kodedokumen')->get()
        ]);
    }

    public function create()
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.dokumen.create');
    }

    public function store(Request $request)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $request->validate([
            'kode'=>'required|min:2|max:2',
            'nama'=>'required',
            'statusdnp'=>'required|min:1|max:1',
            'statuspph'=>'required|min:1|max:1',
        ]);

        
        $request->validate([
            'statusdnp'=>'numeric',
            'statuspph'=>'numeric',
            'kode'=>'numeric',
        ]);

        dokumen::create([
            'kodedokumen'=>$request->kode,
            'namadokumen'=>$request->nama,
            'statusdnp'=>$request->statusdnp,
            'statuspph'=>$request->statuspph,
        ]);
        return redirect('/dokumen');
    }

    public function edit(dokumen $dokuman)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.dokumen.update',[
            'data'=>$dokuman
        ]);
    }

    public function update(Request $request, dokumen $dokuman)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $request->validate([
            'kode'=>'required|min:2|max:2',
            'nama'=>'required',
            'statusdnp'=>'required|min:1|max:1',
            'statuspph'=>'required|min:1|max:1',
            'statusrekanan'=>'required|min:1|max:1',
        ]);

        
        $request->validate([
            'statusdnp'=>'numeric',
            'statuspph'=>'numeric',
            'statusrekanan'=>'numeric',
            'kode'=>'numeric',
        ]);
        $dokuman->update([
            'kodedokumen'=>$request->kode,
            'namadokumen'=>$request->nama,
            'statusdnp'=>$request->statusdnp,
            'statuspph'=>$request->statuspph,
            'statusrekanan'=>$request->statusrekanan,
        ]);
        return redirect('/dokumen');
    }

    public function destroy(dokumen $dokuman)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        
        $dokuman->delete();
        return redirect('/dokumen');
    }
}
