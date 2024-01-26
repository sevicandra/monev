<?php

namespace App\Http\Controllers;

use App\Models\rekanan;
use App\Models\tagihan;
use App\Models\pphrekanan;
use App\Models\ppnrekanan;
use App\Helper\Notification;
use Illuminate\Support\Facades\Gate;

class ArsipController extends Controller
{
    public function index()
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'], auth()->user()->id)) {
            abort(403);
        }

        return view('arsip.index', [
            'data' => tagihan::tagihansatker()->orderby('notagihan', 'desc')->search()->order()->paginate(15)->withQueryString(),
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function dokumen(tagihan $tagihan)
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'], auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('arsip.dokumen', [
            'data' => $tagihan,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function coa(tagihan $tagihan)
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'], auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('arsip.coa', [
            'data' => $tagihan->realisasi()->searchprogram()
                ->searchkegiatan()
                ->searchkro()
                ->searchro()
                ->searchkomponen()
                ->searchsubkomponen()
                ->searchakun()->paginate(15)->withQueryString(),
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function dnp(tagihan $tagihan)
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'], auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('arsip.dnp', [
            'data' => $tagihan->dnp()->search()->paginate(15)->withQueryString(),
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function tolak(tagihan $tagihan)
    {
        if (!Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 5) {
            abort(403);
        }
        $tagihan->update([
            'status' => 4
        ]);
        return redirect('/arsip')->with('berhasil', 'Tagihan Berhasil Di Tolak');
    }

    public function showrekanan(tagihan $tagihan)
    {
        if (!Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('arsip.rekanan.index', [
            'data' => $tagihan->rekanan()->rekanansatker()->search()->paginate(15)->withQueryString(),
            'tagihan' => $tagihan,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function showppnrekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (!Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('arsip.rekanan.ppn.index', [
            'data' => ppnrekanan::myppn($tagihan, $rekanan)->get(),
            'tagihan' => $tagihan,
            'rekanan' => $rekanan,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function showpphrekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (!Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('arsip.rekanan.pph.index', [
            'data' => pphrekanan::mypph($tagihan, $rekanan)->get(),
            'tagihan' => $tagihan,
            'rekanan' => $rekanan,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function showriwayat(tagihan $tagihan)
    {
        return view('arsip.detail', [
            'data' => $tagihan->log()->orderby('created_at', 'DESC')->get(),
            'notifikasi'=>Notification::Notif()
        ]);
    }
}
