<?php

namespace App\Http\Controllers;

use App\Models\spm;
use App\Models\berkas;
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

class VerifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }
        
        return view('verifikasi.index',[
            'data'=>tagihan::tagihansatker()->tagihanverifikator()->unverified()->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(tagihan $tagihan)
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
    public function show(tagihan $verifikasi)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }
       
        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $verifikasi->unit)) {
            abort(403);
        }

        if ($verifikasi->status != 2) {
            abort(403);
        }
        return view('uploadberkas.index',[
            'data'=>$verifikasi,
            'back'=>'/verifikasi',
            'upload'=>'/verifikasi/'.$verifikasi->id.'/upload',
            'delete'=>'/verifikasi/'.$verifikasi->id.'/upload/'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function edit(tagihan $verifikasi)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }

        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $verifikasi->unit)) {
            abort(403);
        }

        if ($verifikasi->status != 2) {
            abort(403);
        }
        if ($verifikasi->jnstagihan != '1') {
            abort(403);
        }
        return view('verifikasi.spm',[
            'data'=>$verifikasi
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tagihan $verifikasi)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }

        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $verifikasi->unit)) {
            abort(403);
        }

        if ($verifikasi->status != 2) {
            abort(403);
        }
        if ($verifikasi->jnstagihan != '1') {
            abort(403);
        }
        $request->validate([
            'tanggal_spm'=>'required'
        ]);
        if (isset($verifikasi->spm)) {
            $verifikasi->spm->update([
                'tanggal_spm'=>$request->tanggal_spm
            ]);
            return redirect('/verifikasi')->with('berhasil','Tanggal SPM Berhasil Ditambahkan');
        }else{
            spm::create([
                'tagihan_id'=>$verifikasi->id,
                'tanggal_spm'=>$request->tanggal_spm
            ]);
            return redirect('/verifikasi')->with('berhasil','Tanggal SPM Berhasil Ditambahkan');
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
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }

        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            abort(403);
        }
        $tagihan->register->delete();
        $tagihan->update([
            'status'=>0
        ]);
        logtagihan::create([
            'tagihan_id'=>$tagihan->id,
            'action'=>'Tolak',
            'user'=>auth()->user()->nama,
            'catatan'=>''
        ]);
        return redirect('/verifikasi')->with('berhasil','Data Tagihan Berhasil Dikembalikan');
    }

    public function approve(tagihan $tagihan){
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }

        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            abort(403);
        }
        switch ($tagihan->jnstagihan) {
            case 0:
                $tagihan->update([
                    'status'=>4
                ]);
                logtagihan::create([
                    'tagihan_id'=>$tagihan->id,
                    'action'=>'Approve',
                    'user'=>auth()->user()->nama,
                    'catatan'=>''
                ]);
                return redirect('/verifikasi')->with('berhasil','Data Tagihan Berhasil Diverifikasi');
                break;

            case 1:
                if (berkasupload::where('tagihan_id', $tagihan->id)->cekberkas3()->first() === null) {
                    return back()->with('gagal','Data tidak dapat dikirim karena berkas belum lengkap.');
                }
                if (!isset($tagihan->spm)) {
                    return back()->with('gagal','Data tidak dapat dikirim karena tanggal SPM belum di input');
                }
                $tagihan->update([
                    'status'=>3
                ]);
                logtagihan::create([
                    'tagihan_id'=>$tagihan->id,
                    'action'=>'Approve',
                    'user'=>auth()->user()->nama,
                    'catatan'=>''
                ]);
                return redirect('/verifikasi')->with('berhasil','Data Tagihan Berhasil Diverifikasi');
                break;
        }
    }

    public function upload(Request $request, tagihan $tagihan, berkasupload $berkas){
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }

        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
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
            return redirect('/verifikasi/'.$tagihan->id)->with('berhasil','Dokumen Berhasil Ditembahkan');
        }

        if ($request->_method === 'DELETE') {
            if ($tagihan->id != $berkas->tagihan_id) {
                abort(403);
            }
            if ($berkas->berkas->kodeberkas === '03' || $berkas->berkas->kodeberkas === '04') {
                Storage::delete($berkas->file);
                $berkas->delete();
                return redirect('/verifikasi/'.$tagihan->id)->with('berhasil','Dokumen Berhasil Di Hapus');
            }else{
                abort(403);
            }
        }

        return view('uploadberkas.upload',[
            'berkas'=>berkas::keuangan()->orderby('kodeberkas')->get(),
            'data'=>$tagihan,
            'back'=>'/verifikasi/'.$tagihan->id,
            'upload'=>'/verifikasi/'.$tagihan->id.'/upload'
        ]);
    }

    public function showrekanan(tagihan $tagihan)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }

        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            abort(403);
        }
        return view('verifikasi.rekanan.index',[
            'data'=>$tagihan
        ]);
    }

    public function createrekanan(tagihan $tagihan)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }

        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            abort(403);
        }
        return view('verifikasi.rekanan.create',[
            'tagihan'=>$tagihan,
            'data'=>rekanan::ofTagihan($tagihan->id)
        ]);
    }

    public function storerekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }

        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            abort(403);
        }
        $tagihan->rekanan()->attach($rekanan->id);

        return redirect('/verifikasi/'.$tagihan->id.'/rekanan')->with('berhasil','Data berhasil Ditambahkan.');
    }

    public function deleterekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }

        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            abort(403);
        }
        $tagihan->rekanan()->detach($rekanan->id);
        pphrekanan::where('rekanan_id', $rekanan->id)->where('tagihan_id', $tagihan->id)->delete();
        ppnrekanan::where('rekanan_id', $rekanan->id)->where('tagihan_id', $tagihan->id)->delete();
        return redirect('/verifikasi/'.$tagihan->id.'/rekanan')->with('berhasil','Data berhasil di Hapus.');
    }

    public function showppnrekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }

        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            abort(403);
        }
        return view('verifikasi.rekanan.ppn.index',[
            'data'=>ppnrekanan::myppn($tagihan, $rekanan)->get(),
            'tagihan'=>$tagihan,
            'rekanan'=>$rekanan
        ]);
    }

    public function createppnrekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }

        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            abort(403);
        }
        return view('verifikasi.rekanan.ppn.create',[
            'data'=>ppnrekanan::myppn($tagihan, $rekanan)->get(),
            'tagihan'=>$tagihan,
            'rekanan'=>$rekanan
        ]);
    }

    public function storeppnrekanan(tagihan $tagihan, rekanan $rekanan, Request $request)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }

        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            abort(403);
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

        return redirect('/verifikasi/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/ppn')->with('berhasil','Data berhasil Ditambahkan.');
    }


    public function editppnrekanan(tagihan $tagihan, rekanan $rekanan, ppnrekanan $ppn)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }

        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            abort(403);
        }
        return view('verifikasi.rekanan.ppn.update',[
            'tagihan'=>$tagihan,
            'rekanan'=>$rekanan,
            'data'=>$ppn
        ]);
    }

    public function updateppnrekanan(tagihan $tagihan, rekanan $rekanan, ppnrekanan $ppn, Request $request)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }

        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            abort(403);
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
        return redirect('/verifikasi/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/ppn')->with('berhasil','Data berhasil di Ubah.');
    }

    public function deleteppnrekanan(tagihan $tagihan, rekanan $rekanan, ppnrekanan $ppn)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }

        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            abort(403);
        }
        if ($ppn->rekanan_id === $rekanan->id && $ppn->tagihan_id === $tagihan->id) {
            $ppn->delete();
            return redirect('/verifikasi/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/ppn')->with('berhasil','Data berhasil di Hapus.');
        }else{
            return redirect('/verifikasi/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/ppn')->with('gagal','Link Error.');
        }
    }

    public function showpphrekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }

        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            abort(403);
        }
        return view('verifikasi.rekanan.pph.index',[
            'data'=>pphrekanan::mypph($tagihan, $rekanan)->get(),
            'tagihan'=>$tagihan,
            'rekanan'=>$rekanan
        ]);
    }

    public function createpphrekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }

        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            abort(403);
        }
        return view('verifikasi.rekanan.pph.create',[
            'data'=>pphrekanan::mypph($tagihan, $rekanan)->get(),
            'tagihan'=>$tagihan,
            'rekanan'=>$rekanan,
            'objekpajak'=>objekpajak::all()
        ]);
    }

    public function storepphrekanan(tagihan $tagihan, rekanan $rekanan, Request $request)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }

        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            abort(403);
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

        return redirect('/verifikasi/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/pph')->with('berhasil','Data berhasil Ditambahkan.');
    }


    public function editpphrekanan(tagihan $tagihan, rekanan $rekanan, pphrekanan $pph)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }

        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            abort(403);
        }
        return view('verifikasi.rekanan.pph.update',[
            'tagihan'=>$tagihan,
            'rekanan'=>$rekanan,
            'data'=>$pph,
            'objekpajak'=>objekpajak::all()
        ]);
    }

    public function updatepphrekanan(tagihan $tagihan, rekanan $rekanan, pphrekanan $pph, Request $request)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }

        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            abort(403);
        }
        $request->validate([
            'objek'=>'required',
            'pph'=>'required|numeric',
        ]);

        $pph->update([
            'objekpajak_id'=>$request->objek,
            'pph'=>$request->pph,
        ]);
        return redirect('/verifikasi/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/pph')->with('berhasil','Data berhasil di Ubah.');
    }

    public function deletepphrekanan(tagihan $tagihan, rekanan $rekanan, pphrekanan $pph)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }

        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            abort(403);
        }
        if ($pph->rekanan_id === $rekanan->id && $pph->tagihan_id === $tagihan->id) {
            $pph->delete();
            return redirect('/verifikasi/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/pph')->with('berhasil','Data berhasil di Hapus.');
        }else{
            return redirect('/verifikasi/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/pph')->with('gagal','Link Error.');
        }
    }
}
