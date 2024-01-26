<?php

namespace App\Http\Controllers;

use App\Models\RefRekening;
use App\Helper\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RefRekeningController extends Controller
{
    public function index()
    {
        if (!Gate::allows('PPK', auth()->user()->id) && !Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.rekening.index', [
            'data' => RefRekening::where('kdsatker', auth()->user()->satker)->search()->paginate(15)->withQueryString(),
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function create()
    {
        if (!Gate::allows('PPK', auth()->user()->id) && !Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.rekening.create', [
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('PPK', auth()->user()->id) && !Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if ($request->bank === "Other") {
            $request->validate([
                'nama' => 'required',
                'kode' => 'required|numeric',
                'norek' => 'required|numeric',
                'otherBank' => 'required',
                'bank' => 'required',

            ]);
            RefRekening::create([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'norek' => $request->norek,
                'bank' => $request->bank,
                'otherbank' => $request->otherBank,
                'kdsatker' => auth()->user()->satker,
            ]);
        } else {
            $request->validate([
                'kode' => 'required|numeric',
                'nama' => 'required',
                'norek' => 'required|numeric',
                'bank' => 'required',

            ]);
            RefRekening::create([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'norek' => $request->norek,
                'bank' => $request->bank,
                'kdsatker' => auth()->user()->satker,
            ]);
        }
        return redirect('/referensi-rekening')->with('berhasil', 'Data berhasil Ditambahkan.');
    }

    public function edit(RefRekening $rekening)
    {
        if (!Gate::allows('PPK', auth()->user()->id) && !Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if ($rekening->kdsatker != auth()->user()->satker) {
            abort(403);
        }
        return view('referensi.rekening.update', [
            'data' => $rekening,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function update(Request $request, RefRekening $rekening)
    {
        if (!Gate::allows('PPK', auth()->user()->id) && !Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if ($rekening->kdsatker != auth()->user()->satker) {
            abort(403);
        }
        if ($request->bank === "Other") {
            $request->validate([
                'nama' => 'required',
                'kode' => 'required|numeric',
                'norek' => 'required|numeric',
                'otherBank' => 'required',
                'bank' => 'required',

            ]);
            $rekening->update([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'norek' => $request->norek,
                'bank' => $request->bank,
                'otherbank' => $request->otherBank
            ]);
        } else {
            $request->validate([
                'kode' => 'required|numeric',
                'nama' => 'required',
                'norek' => 'required|numeric',
                'bank' => 'required',

            ]);
            $rekening->update([
                'kode' => $request->kode,
                'nama' => $request->nama,
                'norek' => $request->norek,
                'bank' => $request->bank,
                'otherbank' => $request->otherBank
            ]);
        }
        return redirect('/referensi-rekening')->with('berhasil', 'Data berhasil Diubah.');
    }

    public function destroy(RefRekening $rekening)
    {
        if (!Gate::allows('PPK', auth()->user()->id) && !Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if ($rekening->kdsatker != auth()->user()->satker) {
            abort(403);
        }
        $rekening->delete();
        return redirect('/referensi-rekening')->with('berhasil', 'Data Berhasil Dihapus.');
    }
}
