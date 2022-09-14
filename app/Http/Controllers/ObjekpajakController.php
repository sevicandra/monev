<?php

namespace App\Http\Controllers;

use App\Models\objekpajak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreobjekpajakRequest;
use App\Http\Requests\UpdateobjekpajakRequest;

class ObjekpajakController extends Controller
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
        return view('referensi.objekpajak.index',[
            'data'=>objekpajak::all()
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
        return view('referensi.objekpajak.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreobjekpajakRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $request->validate([
            'kode'=>'required|min:9|max:9',
            'nama'=>'required',
            'jenis'=>'required',
            'tarif'=>'required|numeric'
        ]);
        objekpajak::create([
            'kode'=>$request->kode,
            'nama'=>$request->nama,
            'jenis'=>$request->jenis,
            'tarif'=>$request->tarif
        ]);
        return redirect('/referensi/objek-pajak')->with('berhasil', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\objekpajak  $objekpajak
     * @return \Illuminate\Http\Response
     */
    public function show(objekpajak $objekpajak)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\objekpajak  $objekpajak
     * @return \Illuminate\Http\Response
     */
    public function edit(objekpajak $objek_pajak)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.objekpajak.update',[
            'data'=>$objek_pajak
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateobjekpajakRequest  $request
     * @param  \App\Models\objekpajak  $objekpajak
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, objekpajak $objek_pajak)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $request->validate([
            'kode'=>'required|min:9|max:9',
            'nama'=>'required',
            'jenis'=>'required',
            'tarif'=>'required|numeric'
        ]);
        $objek_pajak->update([
            'kode'=>$request->kode,
            'nama'=>$request->nama,
            'jenis'=>$request->jenis,
            'tarif'=>$request->tarif
        ]);
        return redirect('/referensi/objek-pajak')->with('berhasil', 'Data Berhasil di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\objekpajak  $objekpajak
     * @return \Illuminate\Http\Response
     */
    public function destroy(objekpajak $objek_pajak)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $objek_pajak->delete();
        return redirect('/referensi/objek-pajak')->with('berhasil', 'Data Berhasil di Hapus');
    }
}
