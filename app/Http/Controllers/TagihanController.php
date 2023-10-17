<?php

namespace App\Http\Controllers;

use App\Models\unit;
use App\Models\berkas;
use App\Models\dokumen;
use App\Models\rekanan;
use App\Models\tagihan;
use App\Models\logtagihan;
use App\Models\objekpajak;
use App\Models\pphrekanan;
use App\Models\ppnrekanan;
use App\Models\berkasupload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class TagihanController extends Controller
{
    public function index()
    {
        if (! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        return view('tagihan.index',[
            'data'=>tagihan::where('status', 0)->where('tahun', session()->get('tahun'))->tagihanppk()->search()->order()->paginate(15)->withQueryString()
        ]);
    }

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

        $tagihan = tagihan::create([
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

        logtagihan::create([
            'tagihan_id'=>$tagihan->id,
            'action'=>'create',
            'user'=>auth()->user()->nama,
            'catatan'=>''
        ]);

        return redirect('/tagihan')->with('berhasil', 'Tagihan Berhasil Dibuat.');
    }

    public function show(tagihan $tagihan)
    {
        //
    }

    public function edit(tagihan $tagihan)
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
        return view('tagihan.update',[
            'data'=>$tagihan,
            'dokumen'=>dokumen::orderby('kodedokumen')->get(),
            'unit'=>unit::Myunit()->stafppk()->get()
        ]);
    }

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

            if ($berkas->berkas->kodeberkas === '01' || $berkas->berkas->kodeberkas === '02') {
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
        logtagihan::create([
            'tagihan_id'=>$tagihan->id,
            'action'=>'Kirim',
            'user'=>auth()->user()->nama,
            'catatan'=>''
        ]);
        return back()->with('berhasil','Data berhasil dikirim.');
    }

    public function showrekanan(tagihan $tagihan)
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
        return view('tagihan.rekanan.index',[
            'data'=>$tagihan->rekanan()->rekanansatker()->search()->paginate(15)->withQueryString(),
            'tagihan'=>$tagihan
        ]);
    }

    public function createrekanan(tagihan $tagihan)
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
        return view('tagihan.rekanan.create',[
            'tagihan'=>$tagihan,
            'data'=>rekanan::rekanansatker()->ofTagihan($tagihan->id)->search()->paginate(15)->withQueryString()
        ]);
    }

    public function storerekanan(tagihan $tagihan, rekanan $rekanan)
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
        $tagihan->rekanan()->attach($rekanan->id);

        return redirect('/tagihan/'.$tagihan->id.'/rekanan')->with('berhasil','Data berhasil Ditambahkan.');
    }

    public function deleterekanan(tagihan $tagihan, rekanan $rekanan)
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
        $tagihan->rekanan()->detach($rekanan->id);

        pphrekanan::where('rekanan_id', $rekanan->id)->where('tagihan_id', $tagihan->id)->delete();
        ppnrekanan::where('rekanan_id', $rekanan->id)->where('tagihan_id', $tagihan->id)->delete();

        return redirect('/tagihan/'.$tagihan->id.'/rekanan')->with('berhasil','Data berhasil di Hapus.');
    }

    public function showppnrekanan(tagihan $tagihan, rekanan $rekanan)
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
        return view('tagihan.rekanan.ppn.index',[
            'data'=>ppnrekanan::myppn($tagihan, $rekanan)->get(),
            'tagihan'=>$tagihan,
            'rekanan'=>$rekanan
        ]);
    }

    public function createppnrekanan(tagihan $tagihan, rekanan $rekanan)
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
        return view('tagihan.rekanan.ppn.create',[
            'data'=>ppnrekanan::myppn($tagihan, $rekanan)->get(),
            'tagihan'=>$tagihan,
            'rekanan'=>$rekanan
        ]);
    }

    public function storeppnrekanan(tagihan $tagihan, rekanan $rekanan, Request $request)
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
            'nomorfaktur'=>'required',
            'tanggalfaktur'=>'required',
            'tarif'=>'required',
            'ppn'=>'required|numeric'
        ]);

        ppnrekanan::create([
            'nomorfaktur'=>$request->nomorfaktur,
            'tanggalfaktur'=>$request->tanggalfaktur,
            'tarif'=>$request->tarif,
            'ppn'=>$request->ppn,
            'tagihan_id'=>$tagihan->id,
            'rekanan_id'=>$rekanan->id,
        ]);

        return redirect('/tagihan/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/ppn')->with('berhasil','Data berhasil Ditambahkan.');
    }


    public function editppnrekanan(tagihan $tagihan, rekanan $rekanan, ppnrekanan $ppn)
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
        return view('tagihan.rekanan.ppn.update',[
            'tagihan'=>$tagihan,
            'rekanan'=>$rekanan,
            'data'=>$ppn
        ]);
    }

    public function updateppnrekanan(tagihan $tagihan, rekanan $rekanan, ppnrekanan $ppn, Request $request)
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
            'nomorfaktur'=>'required',
            'tanggalfaktur'=>'required',
            'tarif'=>'required',
            'ppn'=>'required|numeric'
        ]);

        $ppn->update([
            'nomorfaktur'=>$request->nomorfaktur,
            'tanggalfaktur'=>$request->tanggalfaktur,
            'tarif'=>$request->tarif,
            'ppn'=>$request->ppn,
        ]);
        return redirect('/tagihan/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/ppn')->with('berhasil','Data berhasil di Ubah.');
    }

    public function deleteppnrekanan(tagihan $tagihan, rekanan $rekanan, ppnrekanan $ppn)
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
        if ($ppn->rekanan_id === $rekanan->id && $ppn->tagihan_id === $tagihan->id) {
            $ppn->delete();
            return redirect('/tagihan/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/ppn')->with('berhasil','Data berhasil di Hapus.');
        }else{
            return redirect('/tagihan/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/ppn')->with('gagal','Link Error.');
        }
    }

    public function showpphrekanan(tagihan $tagihan, rekanan $rekanan)
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
        return view('tagihan.rekanan.pph.index',[
            'data'=>pphrekanan::mypph($tagihan, $rekanan)->get(),
            'tagihan'=>$tagihan,
            'rekanan'=>$rekanan
        ]);
    }

    public function createpphrekanan(tagihan $tagihan, rekanan $rekanan)
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
        return view('tagihan.rekanan.pph.create',[
            'data'=>pphrekanan::mypph($tagihan, $rekanan)->get(),
            'tagihan'=>$tagihan,
            'rekanan'=>$rekanan,
            'objekpajak'=>objekpajak::orderBy('kode')->get()
        ]);
    }

    public function storepphrekanan(tagihan $tagihan, rekanan $rekanan, Request $request)
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
            'objek'=>'required',
            'pph'=>'required|numeric',
        ]);

        pphrekanan::create([
            'objekpajak_id'=>$request->objek,
            'pph'=>$request->pph,
            'tagihan_id'=>$tagihan->id,
            'rekanan_id'=>$rekanan->id,
        ]);

        return redirect('/tagihan/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/pph')->with('berhasil','Data berhasil Ditambahkan.');
    }


    public function editpphrekanan(tagihan $tagihan, rekanan $rekanan, pphrekanan $pph)
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
        return view('tagihan.rekanan.pph.update',[
            'tagihan'=>$tagihan,
            'rekanan'=>$rekanan,
            'data'=>$pph,
            'objekpajak'=>objekpajak::all()
        ]);
    }

    public function updatepphrekanan(tagihan $tagihan, rekanan $rekanan, pphrekanan $pph, Request $request)
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
            'objek'=>'required',
            'pph'=>'required|numeric',
        ]);


        $pph->update([
            'objekpajak_id'=>$request->objek,
            'pph'=>$request->pph,
        ]);
        return redirect('/tagihan/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/pph')->with('berhasil','Data berhasil di Ubah.');
    }

    public function deletepphrekanan(tagihan $tagihan, rekanan $rekanan, pphrekanan $pph)
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
        if ($pph->rekanan_id === $rekanan->id && $pph->tagihan_id === $tagihan->id) {
            $pph->delete();
            return redirect('/tagihan/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/pph')->with('berhasil','Data berhasil di Hapus.');
        }else{
            return redirect('/tagihan/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/pph')->with('gagal','Link Error.');
        }
    }

}
