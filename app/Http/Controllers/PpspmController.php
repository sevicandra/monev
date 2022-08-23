<?php

namespace App\Http\Controllers;

use App\Models\spm;
use App\Models\berkas;
use App\Models\tagihan;
use App\Models\berkasupload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PpspmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('ppspm.index',[
            'data'=>tagihan::ppspm()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function show(tagihan $ppspm)
    {
        return view('uploadberkas.index',[
            'data'=>$ppspm,
            'back'=>'/ppspm',
            'upload'=>'/ppspm/'.$ppspm->id.'/upload',
            'delete'=>'/ppspm/'.$ppspm->id.'/upload/'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function edit(tagihan $ppspm)
    {
        if ($ppspm->status != 3) {
            abort(403);
        }
        if ($ppspm->jnstagihan != '1') {
            abort(403);
        }
        return view('ppspm.spm',[
            'data'=>$ppspm
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tagihan $ppspm)
    {
        if ($ppspm->status != 3) {
            abort(403);
        }
        if ($ppspm->jnstagihan != '1') {
            abort(403);
        }
        $request->validate([
            'tanggal_spm'=>'required'
        ]);
        if (isset($ppspm->spm)) {
            $ppspm->spm->update([
                'tanggal_spm'=>$request->tanggal_spm
            ]);
            return redirect('/ppspm');
        }else{
            spm::create([
                'tagihan_id'=>$ppspm->id,
                'tanggal_spm'=>$request->tanggal_spm
            ]);
            return redirect('/ppspm')->with('berhasil', 'Tanggal SPM Berhasil Ditambahkan');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy(tagihan $tagihan)
    {
        //
    }

    public function tolak(tagihan $tagihan){
        if ($tagihan->status != 3) {
            abort(403);
        }
        $tagihan->update([
            'status'=>2
        ]);
        return redirect('/ppspm')->with('berhasil', 'Tagihan Berhasil Ditolak');
    }

    public function approve(tagihan $tagihan){
        if ($tagihan->status != 3) {
            abort(403);
        }
        if (!isset($tagihan->spm)) {
            return back()->with('gagal','Data tidak dapat dikirim karena tanggal SPM belum di input');
        }
        $tagihan->update([
            'status'=>4
        ]);
        return redirect('/ppspm')->with('berhasil', 'Tagihan Berhasil Diverifikasi');
    }

    public function upload(Request $request, tagihan $tagihan, berkasupload $berkas){
        if ($tagihan->status != 3) {
            return abort(403);
        }
        
        if ($request->_method === 'PATCH') {
            $request->validate([
                'berkas'=>'required',
                'uraian'=>'required',
                'fileupload'=>'required|mimes:pdf'
            ]);

            $file = $request->file('fileupload')->store('berkas');
            
            berkasupload::create([
                'tagihan_id'=>$tagihan->id,
                'berkas_id'=>$request->berkas,
                'uraian'=>$request->uraian,
                'file'=>$file
            ]);
            return redirect('/ppspm/'.$tagihan->id)->with('berhasil', 'Dokumen Berhasil Di Uplaod');
        }

        if ($request->_method === 'DELETE') {
            if ($tagihan->id != $berkas->tagihan_id) {
                abort(403);
            }
            if ($berkas->berkas->kodeberkas === '03' || $berkas->berkas->kodeberkas === '04') {
                Storage::delete($berkas->file);
                $berkas->delete();
                return redirect('/ppspm/'.$tagihan->id.'/upload')->with('berhasil', 'Dokumen Berhasil Di Hapus');
            }else{
                abort(403);
            }
        }

        return view('uploadberkas.upload',[
            'berkas'=>berkas::keuangan()->orderby('kodeberkas')->get(),
            'data'=>$tagihan,
            'back'=>'/ppspm/'.$tagihan->id,
            'upload'=>'/ppspm/'.$tagihan->id.'/upload'
        ]);
    }
}
