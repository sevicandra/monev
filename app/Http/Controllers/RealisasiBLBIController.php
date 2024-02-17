<?php

namespace App\Http\Controllers;

use App\Models\pagu;
use App\Models\tagihan;
use App\Models\realisasi;
use App\Helper\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RealisasiBLBIController extends Controller
{
    public function index(tagihan $tagihan)
    {
        if (!Gate::allows('Staf_PPK', auth()->user()->id) && session()->get('staf_ppk_blbi') == 1) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('tagihan-blbi.realisasi.index', [
            'data' => $tagihan->realisasi()->searchprogram()
                ->searchkegiatan()
                ->searchkro()
                ->searchro()
                ->searchkomponen()
                ->searchsubkomponen()
                ->searchakun()->paginate(15)->withQueryString(),
            'tagihan' => $tagihan,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function store(tagihan $tagihan, pagu $pagu)
    {
        if (!Gate::allows('Staf_PPK', auth()->user()->id) && session()->get('staf_ppk_blbi') == 1) {
            abort(403);
        }

        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if (!in_array($pagu->mapingppk->user_id, session()->get('ppk')) || !in_array($pagu->kodeunit, session()->get('unit')) || $pagu->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 0) {
            return abort(403);
        }
        realisasi::create([
            'pagu_id' => $pagu->id,
            'tagihan_id' => $tagihan->id,
            'realisasi' => 0
        ]);
        return redirect('/tagihan-blbi/' . $tagihan->id . '/realisasi')->with('berhasil', 'Realisasi Berhasil Di Tambahkan');
    }

    public function show(tagihan $realisasi)
    {
        if (!Gate::allows('Staf_PPK', auth()->user()->id) && session()->get('staf_ppk_blbi') == 1) {
            abort(403);
        }

        if (!in_array($realisasi->ppk_id, session()->get('ppk')) || !in_array($realisasi->kodeunit, session()->get('unit')) || $realisasi->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('tagihan-blbi.realisasi.tarik_detail_akun', [
            'data' => $realisasi,
            'pagu' => pagu::Pagusatker()->paguppk($realisasi->ppk_id)->PaguUnit($realisasi->kodeunit)->searchprogram()
                ->searchkegiatan()
                ->searchkro()
                ->searchro()
                ->searchkomponen()
                ->searchsubkomponen()
                ->searchakun()->paginate(15)->withQueryString(),
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function edit(realisasi $realisasi)
    {
        if (!Gate::allows('Staf_PPK', auth()->user()->id) && session()->get('staf_ppk_blbi') == 1) {
            abort(403);
        }

        if (!in_array($realisasi->tagihan->ppk_id, session()->get('ppk')) || !in_array($realisasi->tagihan->kodeunit, session()->get('unit')) || $realisasi->tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($realisasi->tagihan->status != 0) {
            return abort(403);
        }
        return view('tagihan-blbi.realisasi.update', [
            'data' => $realisasi,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function update(Request $request, realisasi $realisasi)
    {
        if (!Gate::allows('Staf_PPK', auth()->user()->id) && session()->get('staf_ppk_blbi') == 1) {
            abort(403);
        }

        if (!in_array($realisasi->tagihan->ppk_id, session()->get('ppk')) || !in_array($realisasi->tagihan->kodeunit, session()->get('unit')) || $realisasi->tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($realisasi->tagihan->status != 0) {
            return abort(403);
        }

        $request->validate([
            'realisasi' => 'required|numeric'
        ]);

        $realisasi->update([
            'realisasi' => $request->realisasi
        ]);

        return redirect('/tagihan-blbi/' . $realisasi->tagihan->id . '/realisasi')->with('berhasil', 'Realisasi Berhasil Di Ubah.');
    }

    public function destroy(realisasi $realisasi)
    {
        if (!Gate::allows('Staf_PPK', auth()->user()->id) && session()->get('staf_ppk_blbi') == 1) {
            abort(403);
        }

        if (!in_array($realisasi->tagihan->ppk_id, session()->get('ppk')) || !in_array($realisasi->tagihan->kodeunit, session()->get('unit')) || $realisasi->tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }
        
        if ($realisasi->tagihan->status > 0) {
            return abort(403);
        }
        $tagihan = $realisasi->tagihan;
        $realisasi->delete();
        return redirect('/tagihan-blbi/' . $tagihan->id . '/realisasi')->with('berhasil', 'Realisasi Berhasil Di Hapus');
    }

    
}
