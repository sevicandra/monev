<?php

namespace App\Http\Controllers;

use App\Models\unit;
use App\Models\berkas;
use App\Models\dokumen;
use App\Models\tagihan;
use App\Models\berkasupload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
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
        if (! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        return view('tagihan.index',[
            'data'=>tagihan::where('status', 0)->where('tahun', session()->get('tahun'))->tagihanppk()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        return view('tagihan.create',[
            'dokumen'=>dokumen::orderby('kodedokumen')->get(),
            'unit'=>unit::Myunit()->stafppk()->get()
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
        if (! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
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

        $ppk_id = auth()->user()->mapingstafppk->ppk_id;

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
            'bruto'=>0,
            'ppk_id'=>$ppk_id
        ]);

        return redirect('/tagihan')->with('berhasil', 'Tagihan Berhasil Dibuat.');
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
        if (! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }
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
        if (! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
            abort(403);
        }

        if ($tagihan->status > 0) {
            return abort(403);
        }

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

        return redirect('/tagihan')->with('berhasil', 'Tagihan Berhasil Di Ubah.');;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy(tagihan $tagihan)
    {
        if (! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
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
        foreach ($tagihan->dnp as $item) {
            $item->nominal->delete(); 
            $item->delete();
        }
        $tagihan->delete();
        return redirect('/tagihan')->with('berhasil', 'Tagihan Berhasil Di Hapus.');;
    }

    public function uploadindex(tagihan $tagihan){
        if (! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        
        if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
            abort(403);
        }
        
        return view('uploadberkas.index',[
            'data'=>$tagihan,
            'back'=>'/tagihan',
            'upload'=>'/tagihan/'.$tagihan->id.'/upload/create',
            'delete'=>'/tagihan/'.$tagihan->id.'/upload/'
        ]);
    }

    public function upload(Request $request, tagihan $tagihan, berkasupload $berkas){
        if (! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
            abort(403);
        }

        if ($tagihan->status != 0) {
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
            return redirect('/tagihan/'.$tagihan->id.'/upload')->with('berhasil', 'Dokumen Berhasil Di Upload.');;
        }

        if ($request->_method === 'DELETE') {
            if ($tagihan->id != $berkas->tagihan_id) {
                abort(403);
            }
            if ($berkas->berkas->kodeberkas === '01' && $berkas->berkas->kodeberkas === '02') {
                Storage::delete($berkas->file);
                $berkas->delete();
                return redirect('/tagihan/'.$tagihan->id.'/upload')->with('berhasil', 'Dokumen Berhasil Di Hapus.');;
            }else{
                abort(403);
            }
        }

        return view('uploadberkas.upload',[
            'berkas'=>berkas::ppk()->orderby('kodeberkas')->get(),
            'data'=>$tagihan,
            'back'=>'/tagihan/'.$tagihan->id.'/upload',
            'upload'=>'/tagihan/'.$tagihan->id.'/upload',
        ]);
    }

    public function kirim(tagihan $tagihan)
    {
        if (! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
            abort(403);
        }
        
        if ($tagihan->status > 0) {
            return abort(403);
        }
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
        
        if (berkasupload::where('tagihan_id', $tagihan->id)->cekberkas1()->first() === null && berkasupload::where('tagihan_id', $tagihan->id)->cekberkas2()->first() === null) {
            return back()->with('gagal','Data tidak dapat dikirim karena berkas belum lengkap.');
        }

        $tagihan->update([
            'status'=>'1'
        ]);
        return back()->with('berhasil','Data berhasil dikirim.');
    }
}
