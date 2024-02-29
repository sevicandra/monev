<?php

namespace App\Http\Controllers;

use App\Models\spm;
use App\Models\berkas;
use App\Models\tagihan;
use App\Models\logtagihan;
use App\Helper\Notification;
use App\Models\berkasupload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class PpspmController extends Controller
{
    public function index()
    {
        if (!Gate::allows('PPSPM')) {
            abort(403);
        }

        return view('ppspm.index', [
            'data' => tagihan::tagihansatker()->ppspm()->search()->order()->paginate(15)->withQueryString(),
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function show(tagihan $ppspm)
    {
        if (!Gate::allows('PPSPM')) {
            abort(403);
        }



        return view('uploadberkas.index', [
            'data' => $ppspm->berkasupload()->with('berkas')->get(),
            'back' => '/ppspm',
            'upload' => '/ppspm/' . $ppspm->id . '/upload',
            'delete' => '/ppspm/' . $ppspm->id . '/upload/',
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function edit(tagihan $ppspm)
    {
        if (!Gate::allows('PPSPM')) {
            abort(403);
        }

        if ($ppspm->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($ppspm->status != 3) {
            abort(403);
        }
        if ($ppspm->jnstagihan != '1') {
            abort(403);
        }
        return view('ppspm.spm', [
            'data' => $ppspm,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function update(Request $request, tagihan $ppspm)
    {
        if (!Gate::allows('PPSPM')) {
            abort(403);
        }

        if ($ppspm->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($ppspm->status != 3) {
            abort(403);
        }
        if ($ppspm->jnstagihan != '1') {
            abort(403);
        }
        $request->validate([
            'tanggal_spm' => 'required'
        ]);
        $ppspm->update([
            'tanggal_spm' => $request->tanggal_spm
        ]);
        return redirect('/ppspm');
    }

    public function tolak(tagihan $tagihan)
    {
        if (!Gate::allows('PPSPM')) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 3) {
            abort(403);
        }
        $tagihan->update([
            'status' => 2
        ]);
        logtagihan::create([
            'tagihan_id' => $tagihan->id,
            'action' => 'Tolak',
            'user' => auth()->user()->nama . " / PPSPM",
            'catatan' => ''
        ]);
        return redirect('/ppspm')->with('berhasil', 'Tagihan Berhasil Ditolak');
    }

    public function approve(tagihan $tagihan)
    {
        if (!Gate::allows('PPSPM')) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 3) {
            abort(403);
        }
        if ($tagihan->tanggal_spm == null || $tagihan->tanggal_spm == '0000-00-00') {
            return back()->with('gagal', 'Data tidak dapat dikirim karena tanggal SPM belum di input');
        }
        $tagihan->update([
            'status' => 4
        ]);
        logtagihan::create([
            'tagihan_id' => $tagihan->id,
            'action' => 'Approve',
            'user' => auth()->user()->nama." / PPSPM",
            'catatan' => ''
        ]);
        return redirect('/ppspm')->with('berhasil', 'Tagihan Berhasil Diverifikasi');
    }

    public function upload(Request $request, tagihan $tagihan, berkasupload $berkas)
    {
        if (!Gate::allows('PPSPM')) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 3) {
            return abort(403);
        }

        if ($request->_method === 'PATCH') {
            $request->validate([
                'berkas' => 'required',
                'uraian' => 'required',
                'fileupload' => 'required|mimes:pdf'
            ]);

            $file = $request->file('fileupload')->store('berkas');

            berkasupload::create([
                'tagihan_id' => $tagihan->id,
                'berkas_id' => $request->berkas,
                'uraian' => $request->uraian,
                'file' => $file
            ]);
            return redirect('/ppspm/' . $tagihan->id)->with('berhasil', 'Dokumen Berhasil Di Uplaod');
        }

        if ($request->_method === 'DELETE') {
            if ($tagihan->id != $berkas->tagihan_id) {
                abort(403);
            }
            if ($berkas->berkas->kodeberkas === '03' || $berkas->berkas->kodeberkas === '04') {
                Storage::delete($berkas->file);
                $berkas->delete();
                return redirect('/ppspm/' . $tagihan->id . '/upload')->with('berhasil', 'Dokumen Berhasil Di Hapus');
            } else {
                abort(403);
            }
        }

        return view('uploadberkas.upload', [
            'berkas' => berkas::keuangan()->orderby('kodeberkas')->get(),
            'data' => $tagihan,
            'back' => '/ppspm/' . $tagihan->id,
            'upload' => '/ppspm/' . $tagihan->id . '/upload',
            'notifikasi' => Notification::Notif()
        ]);
    }
}
