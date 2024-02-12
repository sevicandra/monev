<?php

namespace App\Http\Controllers;

use App\Models\RefStafPPK;
use App\Helper\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class RefStafPpkController extends Controller
{
    public function index()
    {
        if (!Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.ref_staf_ppk.index', [
            'data' => RefStafPPK::where('satker', auth()->user()->satker)->get(),
            'notifikasi' => Notification::Notif()
        ]);
    }
    public function create()
    {
        return view('referensi.ref_staf_ppk.create', [
            'notifikasi' => Notification::Notif()
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required|min_digits:18|max_digits:18|unique:ref_staf_ppks,nip'
        ]);

        RefStafPPK::create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'satker' => auth()->user()->satker
        ]);
        return redirect('/maping-staf-ppk')->with('berhasil', 'Data Berhasil Di Tambah');
    }
    public function edit(RefStafPPK $stafppk)
    {
        return view('referensi.ref_staf_ppk.update', [
            'data' => $stafppk,
            'notifikasi' => Notification::Notif()
        ]);
    }
    public function update(Request $request, RefStafPPK $stafppk)
    {
        $request->validate([
            'nama' => 'required',
            'nip' => 'required|min_digits:18|max_digits:18|unique:ref_staf_ppks,nip,' . $stafppk->id
        ]);

        $stafppk->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'satker' => auth()->user()->satker
        ]);
        return redirect('/maping-staf-ppk')->with('berhasil', 'Data Berhasil Di Ubah');
    }
    public function destroy(RefStafPPK $stafppk)
    {
        $stafppk->delete();
        return redirect('/maping-staf-ppk')->with('berhasil', 'Data Berhasil Di Hapus');
    }
}
