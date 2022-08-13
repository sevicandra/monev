<?php

namespace App\Http\Controllers;

use App\Models\unit;
use App\Models\berkas;
use App\Models\dokumen;
use App\Models\tagihan;
use App\Models\berkasupload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdatetagihanRequest;

class TagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('tagihan.index',[
            'data'=>tagihan::where('status', 0)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tagihan.create',[
            'dokumen'=>dokumen::orderby('kodedokumen')->get(),
            'unit'=>unit::Myunit()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoretagihanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'notagihan'=>'required|min:5|max:5',
            'tgltagihan'=>'required',
            'uraian'=>'required',
            'jnstagihan'=>'required',
            'kodeunit'=>'required',
            'kodedokumen'=>'required',
        ]);

        $request->validate([
            'notagihan'=>'numeric',
        ]);

        tagihan::create([
            'notagihan'=>$request->notagihan,
            'tgltagihan'=>$request->tgltagihan,
            'uraian'=>$request->uraian,
            'jnstagihan'=>$request->jnstagihan,
            'kodeunit'=>$request->kodeunit,
            'kodedokumen'=>$request->kodedokumen,
            'status'=>0,
            'tahun'=>session()->get('tahun'),
            'kodesatker'=>auth()->user()->satker,
            'bruto'=>0
        ]);

        return redirect('/tagihan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function show(tagihan $tagihan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function edit(tagihan $tagihan)
    {
        return view('tagihan.update',[
            'data'=>$tagihan,
            'dokumen'=>dokumen::orderby('kodedokumen')->get(),
            'unit'=>unit::Myunit()
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatetagihanRequest  $request
     * @param  \App\Models\tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tagihan $tagihan)
    {
        $request->validate([
            'notagihan'=>'required|min:5|max:5',
            'tgltagihan'=>'required',
            'uraian'=>'required',
            'jnstagihan'=>'required',
            'kodeunit'=>'required',
            'kodedokumen'=>'required',
        ]);

        $request->validate([
            'notagihan'=>'numeric',
        ]);

        $tagihan->update([
            'notagihan'=>$request->notagihan,
            'tgltagihan'=>$request->tgltagihan,
            'uraian'=>$request->uraian,
            'jnstagihan'=>$request->jnstagihan,
            'kodeunit'=>$request->kodeunit,
            'kodedokumen'=>$request->kodedokumen,
            'status'=>0,
            'tahun'=>session()->get('tahun'),
            'kodesatker'=>auth()->user()->satker,
        ]);

        return redirect('/tagihan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy(tagihan $tagihan)
    {
        foreach ($tagihan->berkasupload as $berkas) {
            Storage::delete($berkas->file);
            $berkas->delete();
        }
        foreach ($tagihan->realisasi as $item) {
            $item->delete();
        }
        $tagihan->delete();
        return redirect('/tagihan');
    }

    public function uploadindex(tagihan $tagihan){
        return view('uploadberkas.index',[
            'data'=>$tagihan
        ]);
    }

    public function upload(Request $request, tagihan $tagihan, berkasupload $berkas){
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
            return redirect('/tagihan/'.$tagihan->id.'/upload');
        }

        if ($request->_method === 'DELETE') {
            if ($tagihan->id != $berkas->tagihan_id) {
                abort(403);
            }
            Storage::delete($berkas->file);
            $berkas->delete();
            return redirect('/tagihan/'.$tagihan->id.'/detail');
        }

        return view('uploadberkas.upload',[
            'berkas'=>berkas::orderby('kodeberkas')->get(),
            'data'=>$tagihan
        ]);
    }

    public function kirim(tagihan $tagihan)
    {
        if ($tagihan->realisasi->first() === null) {
            return back()->with('gagal','Data tidak dapat dikirim karena belum dilakukan input realisasi.');    
        }

        if ($tagihan->realisasi->sum('realisasi') <= 0 ) {
            return back()->with('gagal','Data tidak dapat dikirim karena belum dilakukan input realisasi.');
        }
        
        if ($tagihan->dokumen->statusdnp === '1') {
            if ($tagihan->dnp->first() === null) {
                return back()->with('gagal','Data tidak dapat dikirim karena belum dilakukan input DNP.');
            }

            if ($tagihan->nominaldnp->sum('bruto') != $tagihan->realisasi->sum('realisasi')) {
                return back()->with('gagal','Data tidak dapat dikirim karena total dnp tidak sama dengan total tagihan.');
            }

        }
        
        if (berkasupload::where('tagihan_id', $tagihan->id)->cekberkas1()->first() === null || berkasupload::where('tagihan_id', $tagihan->id)->cekberkas2()->first() === null) {
            return back()->with('gagal','Data tidak dapat dikirim karena berkas belum lengkap.');
        }

        $tagihan->update([
            'status'=>'1'
        ]);
        return back()->with('berhasil','Data berhasil dikirim.');
    }
}
