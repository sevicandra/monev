<?php

namespace App\Http\Controllers;

use App\Models\objekpajak;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ObjekpajakController extends Controller
{
    public function index()
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.objekpajak.index',[
            'data'=>objekpajak::search()->orderBy('kode')->paginate(10)->withQueryString()
        ]);
    }

    public function create()
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.objekpajak.create');
    }

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
            'tarif'=>$request->tarif,
            'tarifnonnpwp'=>$request->tarifnonnpwp,
        ]);
        return redirect('/referensi/objek-pajak')->with('berhasil', 'Data Berhasil Ditambahkan');
    }

    public function show(objekpajak $objekpajak)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
    }

    public function edit(objekpajak $objek_pajak)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.objekpajak.update',[
            'data'=>$objek_pajak
        ]);
    }

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
            'tarif'=>$request->tarif,
            'tarifnonnpwp'=>$request->tarifnonnpwp
        ]);
        return redirect('/referensi/objek-pajak')->with('berhasil', 'Data Berhasil di Ubah');
    }

    public function destroy(objekpajak $objek_pajak)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $objek_pajak->delete();
        return redirect('/referensi/objek-pajak')->with('berhasil', 'Data Berhasil di Hapus');
    }
}
