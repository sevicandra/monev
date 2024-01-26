<?php

namespace App\Http\Controllers;

use App\Models\RefPPK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RefPpkController extends Controller
{
    public function index()
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.ref_ppk.index',[
            'data'=>RefPPK::where('satker', auth()->user()->satker)->get()
        ]);
    }
    public function create()
    {
        return view('referensi.ref_ppk.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama'=>'required',
            'nip'=>'required|min_digits:18|max_digits:18|unique:ref_ppks,nip'
        ]);

        RefPPK::create([
            'nama'=>$request->nama,
            'nip'=>$request->nip,
            'satker'=>auth()->user()->satker
        ]);
        return redirect('/ref-ppk')->with('berhasil', 'Data Berhasil Di Tambah');
    }
    public function edit(RefPPK $ppk)
    {
        return view('referensi.ref_ppk.update',[
            'data'=>$ppk
        ]);
    }
    public function update(Request $request, RefPPK $ppk)
    {
        $request->validate([
            'nama'=>'required',
            'nip'=>'required|min_digits:18|max_digits:18|unique:ref_ppks,nip,'.$ppk->id
        ]);

        $ppk->update([
            'nama'=>$request->nama,
            'nip'=>$request->nip,
            'satker'=>auth()->user()->satker
        ]);
        return redirect('/ref-ppk')->with('berhasil', 'Data Berhasil Di Ubah');
    }
    public function destroy(RefPPK $ppk)
    {
        $ppk->delete();
        return redirect('/ref-ppk')->with('berhasil', 'Data Berhasil Di Hapus');
    }
}
