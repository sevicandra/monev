<?php

namespace App\Http\Controllers;

use App\Models\dokumen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoredokumenRequest;
use App\Http\Requests\UpdatedokumenRequest;

class DokumenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.dokumen.index',[
            'data'=>dokumen::orderby('kodedokumen')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.dokumen.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoredokumenRequest  $request
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\dokumen  $dokumen
     * @return \Illuminate\Http\Response
     */
    public function show(dokumen $dokumen)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\dokumen  $dokumen
     * @return \Illuminate\Http\Response
     */
    public function edit(dokumen $dokuman)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.dokumen.update',[
            'data'=>$dokuman
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatedokumenRequest  $request
     * @param  \App\Models\dokumen  $dokumen
     * @return \Illuminate\Http\Response
     */
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
        ]);

        
        $request->validate([
            'statusdnp'=>'numeric',
            'statuspph'=>'numeric',
            'kode'=>'numeric',
        ]);
        $dokuman->update([
            'kodedokumen'=>$request->kode,
            'namadokumen'=>$request->nama,
            'statusdnp'=>$request->statusdnp,
            'statuspph'=>$request->statuspph,
        ]);
        return redirect('/dokumen');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\dokumen  $dokumen
     * @return \Illuminate\Http\Response
     */
    public function destroy(dokumen $dokuman)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $dokuman->delete();
        return redirect('/dokumen');
    }
}
