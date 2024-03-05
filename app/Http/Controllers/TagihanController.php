<?php

namespace App\Http\Controllers;

use App\Helper\Hris;
use App\Models\unit;
use App\Models\berkas;
use App\Models\RefPPK;
use App\Models\dokumen;
use App\Models\Payroll;
use App\Models\rekanan;
use App\Models\tagihan;
use App\Models\logtagihan;
use App\Models\objekpajak;
use App\Models\pphrekanan;
use App\Models\ppnrekanan;
use App\Models\RefRekening;
use Illuminate\Support\Str;
use App\Helper\Notification;
use App\Models\berkasupload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class TagihanController extends Controller
{
    public function index()
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        return view('tagihan.index', [
            'data' => tagihan::with(['stafPpk', 'ppk', 'unit', 'dokumen', 'realisasi'])->where('status', 0)->TagihanNonBLBI()->tagihanStafPPK()->search()->order()->paginate(15)->withQueryString(),
            'notifikasi' => Notification::Notif(),
        ]);
    }

    public function create()
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        return view('tagihan.create', [
            'dokumen' => dokumen::NotBLBI()->orderby('kodedokumen')->get(),
            'unit' => unit::Myunit()->stafppk()->get(),
            'ppk' => RefPPK::PPKsatker()->stafppk()->get(),
            'notifikasi' => Notification::Notif(),
        ]);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        $request->validate([
            'notagihan' => 'required|min:5|max:5',
            'tgltagihan' => 'required',
            'uraian' => 'required',
            'jnstagihan' => 'required',
            'kodeunit' => 'required',
            'kodedokumen' => 'required',
            'ppk' => 'required',
        ]);

        $request->validate([
            'notagihan' => 'numeric',
        ]);

        $tagihan = tagihan::create([
            'notagihan' => $request->notagihan,
            'tgltagihan' => $request->tgltagihan,
            'uraian' => $request->uraian,
            'jnstagihan' => $request->jnstagihan,
            'kodeunit' => $request->kodeunit,
            'kodedokumen' => $request->kodedokumen,
            'staf_ppk'=>auth()->user()->nip,
            'status' => 0,
            'tahun' => session()->get('tahun'),
            'kodesatker' => auth()->user()->satker,
            'bruto' => 0,
            'ppk_id' => $request->ppk,
        ]);

        logtagihan::create([
            'tagihan_id' => $tagihan->id,
            'action' => 'create',
            'user' => auth()->user()->nama,
            'catatan' => '',
        ]);

        return redirect('/tagihan')->with('berhasil', 'Tagihan Berhasil Dibuat.');
    }

    public function show(tagihan $tagihan)
    {
        //
    }

    public function edit(tagihan $tagihan)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 0) {
            return abort(403);
        }
        return view('tagihan.update', [
            'data' => $tagihan,
            'dokumen' => dokumen::orderby('kodedokumen')->get(),
            'unit' => unit::Myunit()->stafppk()->get(),
            'ppk' => RefPPK::PPKsatker()->stafppk()->get(),
            'notifikasi' => Notification::Notif(),
        ]);
    }

    public function update(Request $request, tagihan $tagihan)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }

        $request->validate([
            'notagihan' => 'required|min:5|max:5',
            'tgltagihan' => 'required',
            'uraian' => 'required',
            'jnstagihan' => 'required',
            'kodeunit' => 'required',
            'kodedokumen' => 'required',
            'ppk' => 'required',
        ]);

        $request->validate([
            'notagihan' => 'numeric',
        ]);

        $tagihan->update([
            'notagihan' => $request->notagihan,
            'tgltagihan' => $request->tgltagihan,
            'uraian' => $request->uraian,
            'jnstagihan' => $request->jnstagihan,
            'kodeunit' => $request->kodeunit,
            'kodedokumen' => $request->kodedokumen,
            'status' => 0,
            'tahun' => session()->get('tahun'),
            'kodesatker' => auth()->user()->satker,
            'ppk_id' => $request->ppk,
        ]);

        return redirect('/tagihan')->with('berhasil', 'Tagihan Berhasil Di Ubah.');
    }

    public function destroy(tagihan $tagihan)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 0) {
            return abort(403);
        }

        foreach ($tagihan->berkasupload as $berkas) {
            Storage::delete($berkas->file);
            $berkas->delete();
        }
        foreach ($tagihan->realisasi as $item) {
            $item->delete();
        }
        $tagihan->dnpPerjadin()->delete();
        $tagihan->dnpHonor()->delete();
        // foreach ($tagihan->dnp as $item) {
        //     $item->nominal->delete();
        //     $item->delete();
        // }
        $tagihan->delete();
        return redirect('/tagihan')->with('berhasil', 'Tagihan Berhasil Di Hapus.');
    }

    public function uploadindex(tagihan $tagihan)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('uploadberkas.index', [
            'data' => $tagihan->berkasupload()->with('berkas')->get(),
            'back' => '/tagihan',
            'upload' => '/tagihan/' . $tagihan->id . '/upload/create',
            'delete' => '/tagihan/' . $tagihan->id . '/upload/',
            'notifikasi' => Notification::Notif(),
        ]);
    }

    public function upload(Request $request, tagihan $tagihan, berkasupload $berkas)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 0) {
            return abort(403);
        }

        if ($request->_method === 'PATCH') {
            $request->validate([
                'berkas' => 'required',
                'uraian' => 'required',
                'fileupload' => 'required|mimes:pdf',
            ]);

            $file = $request->file('fileupload')->store('berkas');

            berkasupload::create([
                'tagihan_id' => $tagihan->id,
                'berkas_id' => $request->berkas,
                'uraian' => $request->uraian,
                'file' => $file,
            ]);
            return redirect('/tagihan/' . $tagihan->id . '/upload')->with('berhasil', 'Dokumen Berhasil Di Upload.');
        }

        if ($request->_method === 'DELETE') {
            if ($tagihan->id != $berkas->tagihan_id) {
                abort(403);
            }

            if ($berkas->berkas->kodeberkas === '01' || $berkas->berkas->kodeberkas === '02') {
                Storage::delete($berkas->file);
                $berkas->delete();
                return redirect('/tagihan/' . $tagihan->id . '/upload')->with('berhasil', 'Dokumen Berhasil Di Hapus.');
            } else {
                abort(403);
            }
        }

        return view('uploadberkas.upload', [
            'berkas' => berkas::ppk()->orderby('kodeberkas')->get(),
            'data' => $tagihan,
            'back' => '/tagihan/' . $tagihan->id . '/upload',
            'upload' => '/tagihan/' . $tagihan->id . '/upload',
            'notifikasi' => Notification::Notif(),
        ]);
    }

    public function kirim(tagihan $tagihan)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }
        if ($tagihan->realisasi->first() === null) {
            return back()->with('gagal', 'Data tidak dapat dikirim karena belum dilakukan input realisasi.');
        }

        if ($tagihan->realisasi->sum('realisasi') <= 0) {
            return back()->with('gagal', 'Data tidak dapat dikirim karena belum dilakukan input realisasi.');
        }

        // if ($tagihan->dokumen->statusdnp === '1') {
        //     if ($tagihan->dnp->first() === null) {
        //         return back()->with('gagal','Data tidak dapat dikirim karena belum dilakukan input DNP.');
        //     }

        //     if ($tagihan->nominaldnp->sum('bruto') != $tagihan->realisasi->sum('realisasi')) {
        //         return back()->with('gagal','Data tidak dapat dikirim karena total dnp tidak sama dengan total tagihan.');
        //     }

        // }

        if (
            berkasupload::where('tagihan_id', $tagihan->id)
                ->cekberkas1()
                ->first() === null &&
            berkasupload::where('tagihan_id', $tagihan->id)
                ->cekberkas2()
                ->first() === null
        ) {
            return back()->with('gagal', 'Data tidak dapat dikirim karena berkas belum lengkap.');
        }

        $tagihan->update([
            'status' => '2',
            'catatan' => null
        ]);
        logtagihan::create([
            'tagihan_id' => $tagihan->id,
            'action' => 'Kirim',
            'user' => auth()->user()->nama ." / Staf PPK",
            'catatan' => '',
        ]);
        return back()->with('berhasil', 'Data berhasil dikirim.');
    }

    public function showrekanan(tagihan $tagihan)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }
        return view('tagihan.rekanan.index', [
            'data' => $tagihan->rekanan()->rekanansatker()->search()->paginate(15)->withQueryString(),
            'tagihan' => $tagihan,
            'notifikasi' => Notification::Notif(),
        ]);
    }

    public function createrekanan(tagihan $tagihan)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }
        return view('tagihan.rekanan.create', [
            'tagihan' => $tagihan,
            'data' => rekanan::rekanansatker()
                ->ofTagihan($tagihan->id)
                ->search()
                ->paginate(15)
                ->withQueryString(),
            'notifikasi' => Notification::Notif(),
        ]);
    }

    public function storerekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }
        $tagihan->rekanan()->attach($rekanan->id);

        return redirect('/tagihan/' . $tagihan->id . '/rekanan')->with('berhasil', 'Data berhasil Ditambahkan.');
    }

    public function deleterekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }
        $tagihan->rekanan()->detach($rekanan->id);

        pphrekanan::where('rekanan_id', $rekanan->id)
            ->where('tagihan_id', $tagihan->id)
            ->delete();
        ppnrekanan::where('rekanan_id', $rekanan->id)
            ->where('tagihan_id', $tagihan->id)
            ->delete();

        return redirect('/tagihan/' . $tagihan->id . '/rekanan')->with('berhasil', 'Data berhasil di Hapus.');
    }

    public function showppnrekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }
        return view('tagihan.rekanan.ppn.index', [
            'data' => ppnrekanan::myppn($tagihan, $rekanan)->get(),
            'tagihan' => $tagihan,
            'rekanan' => $rekanan,
            'notifikasi' => Notification::Notif(),
        ]);
    }

    public function createppnrekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }
        return view('tagihan.rekanan.ppn.create', [
            'data' => ppnrekanan::myppn($tagihan, $rekanan)->get(),
            'tagihan' => $tagihan,
            'rekanan' => $rekanan,
            'notifikasi' => Notification::Notif(),
        ]);
    }

    public function storeppnrekanan(tagihan $tagihan, rekanan $rekanan, Request $request)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }
        $request->validate([
            'nomorfaktur' => 'required',
            'tanggalfaktur' => 'required',
            'tarif' => 'required',
            'ppn' => 'required|numeric',
        ]);

        ppnrekanan::create([
            'nomorfaktur' => $request->nomorfaktur,
            'tanggalfaktur' => $request->tanggalfaktur,
            'tarif' => $request->tarif,
            'ppn' => $request->ppn,
            'tagihan_id' => $tagihan->id,
            'rekanan_id' => $rekanan->id,
        ]);

        return redirect('/tagihan/' . $tagihan->id . '/rekanan/' . $rekanan->id . '/ppn')->with('berhasil', 'Data berhasil Ditambahkan.');
    }

    public function editppnrekanan(tagihan $tagihan, rekanan $rekanan, ppnrekanan $ppn)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }
        return view('tagihan.rekanan.ppn.update', [
            'tagihan' => $tagihan,
            'rekanan' => $rekanan,
            'data' => $ppn,
            'notifikasi' => Notification::Notif(),
        ]);
    }

    public function updateppnrekanan(tagihan $tagihan, rekanan $rekanan, ppnrekanan $ppn, Request $request)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }
        $request->validate([
            'nomorfaktur' => 'required',
            'tanggalfaktur' => 'required',
            'tarif' => 'required',
            'ppn' => 'required|numeric',
        ]);

        $ppn->update([
            'nomorfaktur' => $request->nomorfaktur,
            'tanggalfaktur' => $request->tanggalfaktur,
            'tarif' => $request->tarif,
            'ppn' => $request->ppn,
        ]);
        return redirect('/tagihan/' . $tagihan->id . '/rekanan/' . $rekanan->id . '/ppn')->with('berhasil', 'Data berhasil di Ubah.');
    }

    public function deleteppnrekanan(tagihan $tagihan, rekanan $rekanan, ppnrekanan $ppn)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }
        if ($ppn->rekanan_id === $rekanan->id && $ppn->tagihan_id === $tagihan->id) {
            $ppn->delete();
            return redirect('/tagihan/' . $tagihan->id . '/rekanan/' . $rekanan->id . '/ppn')->with('berhasil', 'Data berhasil di Hapus.');
        } else {
            return redirect('/tagihan/' . $tagihan->id . '/rekanan/' . $rekanan->id . '/ppn')->with('gagal', 'Link Error.');
        }
    }

    public function showpphrekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }
        return view('tagihan.rekanan.pph.index', [
            'data' => pphrekanan::mypph($tagihan, $rekanan)->get(),
            'tagihan' => $tagihan,
            'rekanan' => $rekanan,
            'notifikasi' => Notification::Notif(),
        ]);
    }

    public function createpphrekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }
        return view('tagihan.rekanan.pph.create', [
            'data' => pphrekanan::mypph($tagihan, $rekanan)->get(),
            'tagihan' => $tagihan,
            'rekanan' => $rekanan,
            'objekpajak' => objekpajak::orderBy('kode')->get(),
            'notifikasi' => Notification::Notif(),
        ]);
    }

    public function storepphrekanan(tagihan $tagihan, rekanan $rekanan, Request $request)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }

        $request->validate([
            'objek' => 'required',
            'pph' => 'required|numeric',
        ]);

        if ($rekanan->npwp) {
            $tarif = objekpajak::where('kode', $request->objek)->first()->tarif;
        } else {
            $tarif = objekpajak::where('kode', $request->objek)->first()->tarifnonnpwp;
        }

        pphrekanan::create([
            'objekpajak_id' => $request->objek,
            'pph' => $request->pph,
            'tagihan_id' => $tagihan->id,
            'rekanan_id' => $rekanan->id,
            'tarif' => $tarif,
        ]);

        return redirect('/tagihan/' . $tagihan->id . '/rekanan/' . $rekanan->id . '/pph')->with('berhasil', 'Data berhasil Ditambahkan.');
    }

    public function editpphrekanan(tagihan $tagihan, rekanan $rekanan, pphrekanan $pph)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }
        return view('tagihan.rekanan.pph.update', [
            'tagihan' => $tagihan,
            'rekanan' => $rekanan,
            'data' => $pph,
            'objekpajak' => objekpajak::all(),
            'notifikasi' => Notification::Notif(),
        ]);
    }

    public function updatepphrekanan(tagihan $tagihan, rekanan $rekanan, pphrekanan $pph, Request $request)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }
        $request->validate([
            'objek' => 'required',
            'pph' => 'required|numeric',
        ]);
        if ($rekanan->npwp) {
            $tarif = objekpajak::where('kode', $request->objek)->first()->tarif;
        } else {
            $tarif = objekpajak::where('kode', $request->objek)->first()->tarifnonnpwp;
        }

        $pph->update([
            'objekpajak_id' => $request->objek,
            'pph' => $request->pph,
            'tarif' => $tarif,
        ]);
        return redirect('/tagihan/' . $tagihan->id . '/rekanan/' . $rekanan->id . '/pph')->with('berhasil', 'Data berhasil di Ubah.');
    }

    public function deletepphrekanan(tagihan $tagihan, rekanan $rekanan, pphrekanan $pph)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }
        if ($pph->rekanan_id === $rekanan->id && $pph->tagihan_id === $tagihan->id) {
            $pph->delete();
            return redirect('/tagihan/' . $tagihan->id . '/rekanan/' . $rekanan->id . '/pph')->with('berhasil', 'Data berhasil di Hapus.');
        } else {
            return redirect('/tagihan/' . $tagihan->id . '/rekanan/' . $rekanan->id . '/pph')->with('gagal', 'Link Error.');
        }
    }

    public function payroll(tagihan $tagihan)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }
        return view('tagihan.payroll.index', [
            'data' => $tagihan->payroll()->search()->paginate(15)->withQueryString(),
            'tagihan' => $tagihan,
            'notifikasi' => Notification::Notif(),
        ]);
    }

    public function createPayroll(tagihan $tagihan)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }
        return view('tagihan.payroll.create', [
            'tagihan' => $tagihan,
            'notifikasi' => Notification::Notif(),
        ]);
    }

    public function storePayroll(tagihan $tagihan, request $request)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }
        if ($request->bank === 'Other') {
            $request->validate([
                'nama' => 'required',
                'norek' => 'required|numeric',
                'otherBank' => 'required',
                'bruto' => 'required|numeric',
                'pajak' => 'required|numeric',
                'admin' => 'required|numeric',
            ]);
            Payroll::create([
                'nama' => $request->nama,
                'norek' => $request->norek,
                'bank' => $request->otherBank,
                'bruto' => $request->bruto,
                'pajak' => $request->pajak,
                'admin' => $request->admin,
                'tagihan_id' => $tagihan->id,
                'netto' => $request->bruto - $request->pajak - $request->admin,
            ]);
        } else {
            $request->validate([
                'nama' => 'required',
                'norek' => 'required|numeric',
                'bank' => 'required',
                'bruto' => 'required|numeric',
                'pajak' => 'required|numeric',
                'admin' => 'required|numeric',
            ]);
            Payroll::create([
                'nama' => $request->nama,
                'norek' => $request->norek,
                'bank' => $request->bank,
                'bruto' => $request->bruto,
                'pajak' => $request->pajak,
                'admin' => $request->admin,
                'tagihan_id' => $tagihan->id,
                'netto' => $request->bruto - $request->pajak - $request->admin,
            ]);
        }
        return redirect('/tagihan/' . $tagihan->id . '/payroll')->with('berhasil', 'Data berhasil Ditambahkan.');
    }

    public function editPayroll(tagihan $tagihan, Payroll $payroll)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }

        if($tagihan->id != $payroll->tagihan_id){
            return abort(403);
        }

        return view('tagihan.payroll.edit',[
            'tagihan'=>$tagihan,
            'data'=>$payroll,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function updatePayroll(tagihan $tagihan, Payroll $payroll, Request $request)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }

        if($tagihan->id != $payroll->tagihan_id){
            return abort(403);
        }

        if ($request->bank === "Other") {
            $request->validate([
                'nama'=>'required',
                'norek'=>'required|numeric',
                'otherBank'=>'required',
                'bruto'=>'required|numeric',
                'pajak'=>'required|numeric',
                'admin'=>'required|numeric',
            ]);
            $payroll->update([
                'nama'=>$request->nama,
                'norek'=>$request->norek,
                'bank'=>$request->otherBank,
                'bruto'=>$request->bruto,
                'pajak'=>$request->pajak,
                'admin'=>$request->admin,
                'tagihan_id'=>$tagihan->id,
                'netto'=>$request->bruto-$request->pajak-$request->admin,
            ]);
        }else{
            $request->validate([
                'nama'=>'required',
                'norek'=>'required|numeric',
                'bank'=>'required',
                'bruto'=>'required|numeric',
                'pajak'=>'required|numeric',
                'admin'=>'required|numeric',
            ]);
            $payroll->update([
                'nama'=>$request->nama,
                'norek'=>$request->norek,
                'bank'=>$request->bank,
                'bruto'=>$request->bruto,
                'pajak'=>$request->pajak,
                'admin'=>$request->admin,
                'tagihan_id'=>$tagihan->id,
                'netto'=>$request->bruto-$request->pajak-$request->admin,
            ]);
        }
        return redirect('/tagihan/'.$tagihan->id.'/payroll')->with('berhasil','Data berhasil Ditambahkan.');
    }

    public function importHrisPayroll(tagihan $tagihan)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }
        if (request('nip')) {
            $data = Hris::getRekening(request('nip'));
        } else {
            $data = [];
        }
        return view('tagihan.payroll.hris.import', [
            'data' => $data,
            'tagihan' => $tagihan,
            'notifikasi' => Notification::Notif(),
        ]);
    }

    public function importMonevPayroll(tagihan $tagihan)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }

        return view('tagihan.payroll.monev.import', [
            'data' => RefRekening::search()->paginate(15)->withQueryString(),
            'tagihan' => $tagihan,
            'notifikasi' => Notification::Notif(),
        ]);
    }

    public function importExcelPayroll(tagihan $tagihan)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }
        if ($tagihan->status > 0) {
            return abort(403);
        }
        return view('tagihan.payroll.excel.import', [
            'tagihan' => $tagihan,
            'notifikasi' => Notification::Notif(),
        ]);
    }

    public function templateExcelPayroll()
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }

        $spreadsheet = new Spreadsheet();

        $spreadsheet->setActiveSheetIndex(0)->setTitle('BNI')->setCellValue('A1', 'No')->setCellValue('B1', 'NOREK')->setCellValue('C1', 'NAMA')->setCellValue('D1', 'BRUTO')->setCellValue('E1', 'PAJAK');
        $spreadsheet->setActiveSheetIndex(0)->setCellValue('A2', '1')->setCellValue('B2', '123456789')->setCellValue('C2', 'xxxxxxxxxx')->setCellValue('D2', '1000000')->setCellValue('E2', '100000')->setCellValue('F2', 'data contoh jangan di hapus');
        $spreadsheet
            ->setActiveSheetIndex(0)
            ->getStyle('A:F')
            ->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
        $spreadsheet
            ->setActiveSheetIndex(0)
            ->getStyle('D:E')
            ->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $spreadsheet
            ->setActiveSheetIndex(0)
            ->getStyle('D1:E1')
            ->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
        foreach ($spreadsheet->setActiveSheetIndex(0)->getColumnIterator() as $column) {
            $spreadsheet->setActiveSheetIndex(0)->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A2:H2')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A2:H2')
            ->getFill()
            ->getStartColor()
            ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_YELLOW);
        $NonBNISheet = $spreadsheet->createSheet();
        $NonBNISheet->setTitle('Non BNI');
        $spreadsheet->setActiveSheetIndex(1)->setCellValue('A1', 'No')->setCellValue('B1', 'NOREK')->setCellValue('C1', 'NAMA')->setCellValue('D1', 'BRUTO')->setCellValue('E1', 'PAJAK')->setCellValue('F1', 'ADMIN')->setCellValue('G1', 'BANK');
        $spreadsheet->setActiveSheetIndex(1)->setCellValue('A2', '1')->setCellValue('B2', '123456789')->setCellValue('C2', 'xxxxxxxxxx')->setCellValue('D2', '1000000')->setCellValue('E2', '100000')->setCellValue('F2', '2900')->setCellValue('G2', 'BRI/Mandiri/BSI dll')->setCellValue('H2', 'data contoh jangan di hapus');
        $spreadsheet
            ->setActiveSheetIndex(1)
            ->getStyle('A:H')
            ->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
        $spreadsheet
            ->setActiveSheetIndex(1)
            ->getStyle('D:F')
            ->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $spreadsheet
            ->setActiveSheetIndex(1)
            ->getStyle('D1:F1')
            ->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
        foreach ($spreadsheet->setActiveSheetIndex(1)->getColumnIterator() as $column) {
            $spreadsheet->setActiveSheetIndex(1)->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A2:H2')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A2:H2')
            ->getFill()
            ->getStartColor()
            ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_YELLOW);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Payroll -' . date('D, d M Y H:i:s') . '.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit();
    }

    public function storeExcelPayroll(Request $request, tagihan $tagihan)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }
        if ($tagihan->status > 0) {
            return abort(403);
        }
        $file = $request->file('file');
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($file);
        $bni = collect($spreadsheet->getSheetByName('BNI')->toArray())->skip(1);
        // return $bni;

        $bniErrors = collect();
        foreach ($bni as $item) {
            $row = collect([
                'NOREK' => $item[1],
                'NAMA' => $item[2],
                'BRUTO' => $item[3],
                'PAJAK' => $item[4],
            ]);
            $validator = Validator::make(
                $row->all(),
                [
                    'NOREK' => 'required|numeric',
                    'NAMA' => 'required',
                    'BRUTO' => ['required', 'regex:/^((\d*)|(\d{1,3}(,\d{3})+))(\.\d+)?$/'],
                    'PAJAK' => ['required', 'regex:/^((\d*)|(\d{1,3}(,\d{3})+))(\.\d+)?$/'],
                ],
                [
                    'NOREK.required' => 'Nomor Rekening tidak boleh kosong',
                    'NOREK.numeric' => 'Nomor Rekening harus berupa angka',
                    'NAMA.required' => 'Nama tidak boleh kosong',
                    'BRUTO.required' => 'Bruto tidak boleh kosong',
                    'BRUTO.regex' => 'Bruto tidak sesuai format nominal mohon jangan mengubah format cell ' . $item[3],
                    'PAJAK.required' => 'Pajak tidak boleh kosong',
                    'PAJAK.regex' => 'Pajak tidak sesuai format nominal mohon jangan mengubah format cell ' . $item[4],
                ],
            );
            if ($validator->fails()) {
                $detail = (object) [];
                $detail->errors = (object) [];
                $errorMessage = json_decode($validator->errors()->toJson());
                if (isset($errorMessage->NOREK)) {
                    $detail->errors->NOREK = $errorMessage->NOREK[0];
                } else {
                    $detail->errors->NOREK = 'ok';
                }
                if (isset($errorMessage->NAMA)) {
                    $detail->errors->NAMA = $errorMessage->NAMA[0];
                } else {
                    $detail->errors->NAMA = 'ok';
                }
                if (isset($errorMessage->BRUTO)) {
                    $detail->errors->BRUTO = $errorMessage->BRUTO[0];
                } else {
                    $detail->errors->BRUTO = 'ok';
                }
                if (isset($errorMessage->PAJAK)) {
                    $detail->errors->PAJAK = $errorMessage->PAJAK[0];
                } else {
                    $detail->errors->PAJAK = 'ok';
                }
                $detail->row = $item[0];
                $detail->status = false;
                $bniErrors->push($detail);
            } else {
                $detail = (object) [];
                $detail->errors = (object) [];
                $detail->errors->NOREK = 'ok';
                $detail->errors->NAMA = 'ok';
                $detail->errors->BRUTO = 'ok';
                $detail->errors->PAJAK = 'ok';
                $detail->row = $item[0];
                $detail->status = true;
                $bniErrors->push($detail);
            }
        }
        $nonBNI = collect($spreadsheet->getSheetByName('Non BNI')->toArray())->skip(1);
        $nonBniErrors = collect();
        foreach ($nonBNI as $item) {
            $row = collect([
                'NOREK' => $item[1],
                'NAMA' => $item[2],
                'BRUTO' => $item[3],
                'PAJAK' => $item[4],
                'ADMIN' => $item[5],
                'BANK' => $item[6],
            ]);
            $validator = Validator::make(
                $row->all(),
                [
                    'NOREK' => 'required|numeric',
                    'NAMA' => 'required',
                    'BRUTO' => ['required', 'regex:/^((\d*)|(\d{1,3}(,\d{3})+))(\.\d+)?$/'],
                    'PAJAK' => ['required', 'regex:/^((\d*)|(\d{1,3}(,\d{3})+))(\.\d+)?$/'],
                    'ADMIN' => ['required', 'regex:/^((\d*)|(\d{1,3}(,\d{3})+))(\.\d+)?$/'],
                    'BANK' => 'required',
                ],
                [
                    'NOREK.required' => 'Nomor Rekening tidak boleh kosong',
                    'NOREK.numeric' => 'Nomor Rekening harus berupa angka',
                    'NAMA.required' => 'Nama tidak boleh kosong',
                    'BRUTO.required' => 'Bruto tidak boleh kosong',
                    'BRUTO.regex' => 'Bruto tidak sesuai format nominal mohon jangan mengubah format cell ' . $item[3],
                    'PAJAK.required' => 'Pajak tidak boleh kosong',
                    'PAJAK.regex' => 'Pajak tidak sesuai format nominal mohon jangan mengubah format cell ' . $item[4],
                    'ADMIN.required' => 'Biaya Admin tidak boleh kosong',
                    'ADMIN.regex' => 'Biaya Admin tidak sesuai format nominal mohon jangan mengubah format cell ' . $item[4],
                    'BANK.required' => 'Nomor Rekening tidak boleh kosong',
                ],
            );
            if ($validator->fails()) {
                $detail = (object) [];
                $detail->errors = (object) [];
                $errorMessage = json_decode($validator->errors()->toJson());
                if (isset($errorMessage->NOREK)) {
                    $detail->errors->NOREK = $errorMessage->NOREK[0];
                } else {
                    $detail->errors->NOREK = 'ok';
                }
                if (isset($errorMessage->NAMA)) {
                    $detail->errors->NAMA = $errorMessage->NAMA[0];
                } else {
                    $detail->errors->NAMA = 'ok';
                }
                if (isset($errorMessage->BRUTO)) {
                    $detail->errors->BRUTO = $errorMessage->BRUTO[0];
                } else {
                    $detail->errors->BRUTO = 'ok';
                }
                if (isset($errorMessage->PAJAK)) {
                    $detail->errors->PAJAK = $errorMessage->PAJAK[0];
                } else {
                    $detail->errors->PAJAK = 'ok';
                }
                if (isset($errorMessage->ADMIN)) {
                    $detail->errors->ADMIN = $errorMessage->ADMIN[0];
                } else {
                    $detail->errors->ADMIN = 'ok';
                }
                if (isset($errorMessage->BANK)) {
                    $detail->errors->BANK = $errorMessage->BANK[0];
                } else {
                    $detail->errors->BANK = 'ok';
                }
                $detail->row = $item[0];
                $detail->status = false;
                $nonBniErrors->push($detail);
            } else {
                $detail = (object) [];
                $detail->errors = (object) [];
                $detail->errors->NOREK = 'ok';
                $detail->errors->NAMA = 'ok';
                $detail->errors->BRUTO = 'ok';
                $detail->errors->PAJAK = 'ok';
                $detail->errors->ADMIN = 'ok';
                $detail->errors->BANK = 'ok';
                $detail->row = $item[0];
                $detail->status = true;
                $nonBniErrors->push($detail);
            }
        }

        if ($bniErrors->min('status') === true && $nonBniErrors->min('status') === true) {
            foreach ($bni->skip(1) as $item) {
                Payroll::create([
                    'nama' => $item[2],
                    'norek' => $item[1],
                    'bank' => 'BNI',
                    'bruto' => floatval(str_replace(',', '', $item[3])),
                    'pajak' => floatval(str_replace(',', '', $item[4])),
                    'admin' => 0,
                    'tagihan_id' => $tagihan->id,
                    'netto' => floatval(str_replace(',', '', $item[3])) - floatval(str_replace(',', '', $item[4])),
                ]);
            }
            foreach ($nonBNI->skip(1) as $item) {
                Payroll::create([
                    'nama' => $item[2],
                    'norek' => $item[1],
                    'bank' => $item[6],
                    'bruto' => floatval(str_replace(',', '', $item[3])),
                    'pajak' => floatval(str_replace(',', '', $item[4])),
                    'admin' => floatval(str_replace(',', '', $item[5])),
                    'tagihan_id' => $tagihan->id,
                    'netto' => floatval(str_replace(',', '', $item[3])) - floatval(str_replace(',', '', $item[4])) - floatval(str_replace(',', '', $item[5])),
                ]);
            }
            return redirect('/tagihan/' . $tagihan->id . '/payroll')->with('berhasil', 'Data berhasil Ditambahkan.');
        } else {
            return redirect('/tagihan/' . $tagihan->id . '/payroll/import-excel')
                ->with('gagal', 'Data gagal ditambahkan. Silahkan cek kembali.')
                ->with('bniErrors', collect($bniErrors->skip(1)))
                ->with('nonBniErrors', collect($nonBniErrors->skip(1)));
        }
    }

    public function storeImportPayroll(tagihan $tagihan, request $request)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }
        if ($tagihan->status > 0) {
            return abort(403);
        }

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'norek' => 'required|numeric',
            'bank' => 'required',
            'bruto' => 'required|numeric',
            'pajak' => 'required|numeric',
            'admin' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return back()->with('gagal', 'semua data harus diisi');
        }
        Payroll::create([
            'nama' => $request->nama,
            'norek' => $request->norek,
            'bank' => $request->bank,
            'bruto' => $request->bruto,
            'pajak' => $request->pajak,
            'admin' => $request->admin,
            'tagihan_id' => $tagihan->id,
            'netto' => $request->bruto - $request->pajak - $request->admin,
        ]);
        return redirect('/tagihan/' . $tagihan->id . '/payroll')->with('berhasil', 'Data berhasil Ditambahkan.');
    }

    public function deletePayroll(tagihan $tagihan, Payroll $payroll)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }
        $payroll->delete();
        return redirect('/tagihan/' . $tagihan->id . '/payroll')->with('berhasil', 'Data berhasil di Hapus.');
    }

    public function cetakPayroll(tagihan $tagihan)
    {
        if (!Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }

        switch ($tagihan->jnstagihan) {
            case '0':
                $type = 'SPBy';
                break;
            case '1':
                $type = 'SPM';
                break;
            case '2':
                $type = 'KKP';
        }
        $spreadsheet = new Spreadsheet();
        $styleBorder = [
            'borders' => [
                'outline' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
                'inside' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];

        $textcenter = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];
        $spreadsheet
            ->setActiveSheetIndex(0)
            ->setCellValue('B1', 'Payroll ' . $type . ' ' . $tagihan->notagihan)
            ->mergeCells('B1:I1')
            ->setCellValue('B2', $tagihan->uraian)
            ->mergeCells('B2:I2')
            ->setCellValue('B4', 'BNI')
            ->mergeCells('B4:I4');

        $spreadsheet->getActiveSheet()->getStyle('B1:C2')->applyFromArray($textcenter);
        $spreadsheet->getActiveSheet()->setCellValue('B5', 'No.')->setCellValue('C5', 'Nomor Rekening')->setCellValue('D5', 'Nama Penerima')->setCellValue('E5', 'Bruto')->setCellValue('F5', 'Pajak')->setCellValue('G5', 'Biaya Admin')->setCellValue('H5', 'Netto')->setCellValue('I5', 'Bank');
        $spreadsheet->getActiveSheet()->getStyle('B5:I5')->applyFromArray($textcenter);
        $i = 0;
        foreach ($tagihan->payroll as $payroll) {
            if (Str::upper($payroll->bank) === 'BANK NEGARA INDONESIA' || Str::upper($payroll->bank) === 'BNI' || Str::upper($payroll->bank) === 'BANK NEGARAINDONESIA' || Str::upper($payroll->bank) === 'BANKNEGARA INDONESIA' || Str::upper($payroll->bank) === 'BANKNEGARAINDONESIA') {
                $i++;
                $spreadsheet
                    ->getActiveSheet()
                    ->setCellValue('B' . ($i + 5), $i)
                    ->setCellValue('D' . ($i + 5), $payroll->nama)
                    ->setCellValue('E' . ($i + 5), $payroll->bruto)
                    ->setCellValue('F' . ($i + 5), $payroll->pajak)
                    ->setCellValue('G' . ($i + 5), $payroll->admin)
                    ->setCellValue('H' . ($i + 5), $payroll->netto)
                    ->setCellValue('I' . ($i + 5), $payroll->bank);
                $spreadsheet
                    ->getActiveSheet()
                    ->getCell('C' . ($i + 5))
                    ->setValueExplicit($payroll->norek, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            }
        }
        $spreadsheet
            ->getActiveSheet()
            ->setCellValue('B' . ($i + 7), 'Jumlah')
            ->setCellValue('E' . ($i + 7), '=SUM(E5:E' . ($i + 5) . ')')
            ->setCellValue('F' . ($i + 7), '=SUM(F5:F' . ($i + 5) . ')')
            ->setCellValue('G' . ($i + 7), '=SUM(G5:G' . ($i + 5) . ')')
            ->setCellValue('H' . ($i + 7), '=SUM(H5:H' . ($i + 5) . ')')
            ->mergeCells('B' . ($i + 7) . ':D' . ($i + 7));
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('E5:H' . ($i + 7))
            ->getNumberFormat()
            ->setFormatCode('#,##0.00');
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('B5:I' . ($i + 7))
            ->applyFromArray($styleBorder);

        $nonBNIcol = $i + 9;
        $spreadsheet
            ->getActiveSheet()
            ->setCellValue('B' . $nonBNIcol, 'NON BNI')
            ->mergeCells('B' . $nonBNIcol . ':I' . $nonBNIcol);
        $spreadsheet
            ->getActiveSheet()
            ->setCellValue('B' . $nonBNIcol + 1, 'No.')
            ->setCellValue('C' . $nonBNIcol + 1, 'Nomor Rekening')
            ->setCellValue('D' . $nonBNIcol + 1, 'Nama Penerima')
            ->setCellValue('E' . $nonBNIcol + 1, 'Bruto')
            ->setCellValue('F' . $nonBNIcol + 1, 'Pajak')
            ->setCellValue('G' . $nonBNIcol + 1, 'Biaya Admin')
            ->setCellValue('H' . $nonBNIcol + 1, 'Netto')
            ->setCellValue('I' . $nonBNIcol + 1, 'Bank');
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('B' . $nonBNIcol + 1 . ':I' . $nonBNIcol + 1)
            ->applyFromArray($textcenter);
        $j = 0;
        foreach ($tagihan->payroll as $payroll) {
            if (!(Str::upper($payroll->bank) === 'BANK NEGARA INDONESIA' || Str::upper($payroll->bank) === 'BNI' || Str::upper($payroll->bank) === 'BANK NEGARAINDONESIA' || Str::upper($payroll->bank) === 'BANKNEGARA INDONESIA' || Str::upper($payroll->bank) === 'BANKNEGARAINDONESIA')) {
                $j++;
                $spreadsheet
                    ->getActiveSheet()
                    ->setCellValue('B' . $nonBNIcol + 1 + $j, $j)
                    ->setCellValue('D' . $nonBNIcol + 1 + $j, $payroll->nama)

                    ->setCellValue('E' . $nonBNIcol + 1 + $j, $payroll->bruto)
                    ->setCellValue('F' . $nonBNIcol + 1 + $j, $payroll->pajak)
                    ->setCellValue('G' . $nonBNIcol + 1 + $j, $payroll->admin)
                    ->setCellValue('H' . $nonBNIcol + 1 + $j, $payroll->netto)
                    ->setCellValue('I' . $nonBNIcol + 1 + $j, $payroll->bank);
                $spreadsheet
                    ->getActiveSheet()
                    ->getCell('C' . $nonBNIcol + 1 + $j)
                    ->setValueExplicit($payroll->norek, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            }
        }
        $spreadsheet
            ->getActiveSheet()
            ->setCellValue('B' . $nonBNIcol + 3 + $j, 'Jumlah')
            ->setCellValue('E' . $nonBNIcol + 3 + $j, '=SUM(E' . $nonBNIcol + 2 . ':E' . $nonBNIcol + 2 + $j . ')')
            ->setCellValue('F' . $nonBNIcol + 3 + $j, '=SUM(F' . $nonBNIcol + 2 . ':F' . $nonBNIcol + 2 + $j . ')')
            ->setCellValue('G' . $nonBNIcol + 3 + $j, '=SUM(G' . $nonBNIcol + 2 . ':G' . $nonBNIcol + 2 + $j . ')')
            ->setCellValue('H' . $nonBNIcol + 3 + $j, '=SUM(H' . $nonBNIcol + 2 . ':H' . $nonBNIcol + 2 + $j . ')')
            ->mergeCells('B' . $nonBNIcol + 3 + $j . ':D' . $nonBNIcol + 3 + $j);
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('E' . $nonBNIcol + 2 . ':H' . $nonBNIcol + 3 + $j)
            ->getNumberFormat()
            ->setFormatCode('#,##0.00');
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('B' . $nonBNIcol + 1 . ':I' . $nonBNIcol + 3 + $j)
            ->applyFromArray($styleBorder);
        foreach ($spreadsheet->getActiveSheet()->getColumnIterator() as $column) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $totalCol = $nonBNIcol + $j + 6;
        $spreadsheet
            ->getActiveSheet()
            ->setCellValue('E' . $totalCol, '=E' . $nonBNIcol + 3 + $j . '+' . 'E' . ($i + 7))
            ->setCellValue('F' . $totalCol, '=F' . $nonBNIcol + 3 + $j . '+' . 'F' . ($i + 7))
            ->setCellValue('G' . $totalCol, '=G' . $nonBNIcol + 3 + $j . '+' . 'G' . ($i + 7))
            ->setCellValue('H' . $totalCol, '=H' . $nonBNIcol + 3 + $j . '+' . 'H' . ($i + 7));
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('E' . $totalCol . ':H' . $totalCol)
            ->getNumberFormat()
            ->setFormatCode('#,##0.00');
        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Payroll ' . $type . ' ' . $tagihan->notagihan . '-' . date('D, d M Y H:i:s') . '.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit();
    }
}
