<?php

namespace App\Http\Controllers;

use App\Models\spm;
use App\Helper\Hris;
use App\Models\berkas;
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

class VerifikasiController extends Controller
{
    public function index()
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }
        
        return view('verifikasi.index',[
            'data'=>tagihan::tagihansatker()->tagihanverifikator()->unverified()->search()->order()->paginate(15)->withQueryString(),
            'notifikasi'=>Notification::Notif()
        ]);
    }

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
            'delete'=>'/verifikasi/'.$verifikasi->id.'/upload/',
            'notifikasi'=>Notification::Notif()
        ]);
    }

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
            'data'=>$verifikasi,
            'notifikasi'=>Notification::Notif()
        ]);
    }

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
        $verifikasi->update([
            'tanggal_spm'=>$request->tanggal_spm
        ]);
        return redirect('/verifikasi')->with('berhasil','Tanggal SPM Berhasil Ditambahkan');
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
                if ($tagihan->tanggal_spm == null) {
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
            case 2:
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
            'upload'=>'/verifikasi/'.$tagihan->id.'/upload',
            'notifikasi'=>Notification::Notif()
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
            'data'=>$tagihan->rekanan()->rekanansatker()->search()->paginate(15)->withQueryString(),
            'tagihan'=>$tagihan,
            'notifikasi'=>Notification::Notif()
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
            'data'=>rekanan::rekanansatker()->ofTagihan($tagihan->id)->search()->paginate(15)->withQueryString(),
            'notifikasi'=>Notification::Notif()
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
            'rekanan'=>$rekanan,
            'notifikasi'=>Notification::Notif()
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
            'rekanan'=>$rekanan,
            'notifikasi'=>Notification::Notif()
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
            'data'=>$ppn,
            'notifikasi'=>Notification::Notif()
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
            'rekanan'=>$rekanan,
            'notifikasi'=>Notification::Notif()
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
            'objekpajak'=>objekpajak::all(),
            'notifikasi'=>Notification::Notif()
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

        if($rekanan->npwp){
            $tarif = objekpajak::where('kode',$request->objek)->first()->tarif;
        }else{
            $tarif = objekpajak::where('kode',$request->objek)->first()->tarifnonnpwp;
        }

        pphrekanan::create([
            'objekpajak_id'=>$request->objek,
            'pph'=>$request->pph,
            'tagihan_id'=>$tagihan->id,
            'rekanan_id'=>$rekanan->id,
            'tarif'=>$tarif
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
            'objekpajak'=>objekpajak::all(),
            'notifikasi'=>Notification::Notif()
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

        if($rekanan->npwp){
            $tarif = objekpajak::where('kode',$request->objek)->first()->tarif;
        }else{
            $tarif = objekpajak::where('kode',$request->objek)->first()->tarifnonnpwp;
        }

        $pph->update([
            'objekpajak_id'=>$request->objek,
            'pph'=>$request->pph,
            'tarif'=>$tarif
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

    public function coa(tagihan $tagihan)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }

        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }
        
        return view('verifikasi.coa',[
            'data'=>$tagihan->realisasi() ->searchprogram()  
                                            ->searchkegiatan()
                                            ->searchkro()
                                            ->searchro()
                                            ->searchkomponen()
                                            ->searchsubkomponen()
                                            ->searchakun()->paginate(15)->withQueryString(),
            'tagihan'=>$tagihan,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function payroll(tagihan $tagihan)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }
       
        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            return abort(403);
        }
        return view('verifikasi.payroll.index',[
           'data'   => $tagihan->payroll()->search()->paginate(15)->withQueryString(),
           'tagihan' => $tagihan,
           'notifikasi'=>Notification::Notif()
        ]);
    }

    public function createPayroll(tagihan $tagihan)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }
       
        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            return abort(403);
        }
        return view('verifikasi.payroll.create',[
            'tagihan'=>$tagihan,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function storePayroll(tagihan $tagihan, request $request)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }
       
        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
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
            Payroll::create([
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
            Payroll::create([
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
        return redirect('/verifikasi/'.$tagihan->id.'/payroll')->with('berhasil','Data berhasil Ditambahkan.');
    }

    public function importHrisPayroll(tagihan $tagihan)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }
       
        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            return abort(403);
        }
        if (request('nip')) {
            $data = Hris::getRekening(request('nip'));
        }else{
            $data = [];
        }
        return view('verifikasi.payroll.hris.import',[
            'data'=>$data,
            'tagihan'=>$tagihan,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function importMonevPayroll(tagihan $tagihan)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }
       
        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            return abort(403);
        }

        return view('verifikasi.payroll.monev.import',[
            'data'=>RefRekening::search()->paginate(15)->withQueryString(),
            'tagihan'=>$tagihan,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function storeImportPayroll(tagihan $tagihan, request $request)
    {
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }
       
        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }
        if ($tagihan->status != 2) {
            return abort(403);
        }

        $validator = Validator::make($request->all(),[
            'nama'=>'required',
            'norek'=>'required|numeric',
            'bank'=>'required',
            'bruto'=>'required|numeric',
            'pajak'=>'required|numeric',
            'admin'=>'required|numeric',
        ]);
        if ($validator->fails()){
            return back()->with('gagal','semua data harus diisi');
        }
        Payroll::create([
            'nama'=>$request->nama,
            'norek'=>$request->norek,
            'bank'=>$request->bank,
            'bruto'=>$request->bruto,
            'pajak'=>$request->pajak,
            'admin'=>$request->admin,
            'tagihan_id'=>$tagihan->id,
            'netto'=>$request->bruto-$request->pajak-$request->admin,
        ]);
        return redirect('/verifikasi/'.$tagihan->id.'/payroll')->with('berhasil','Data berhasil Ditambahkan.');
    }

    public function deletePayroll(tagihan $tagihan, Payroll $payroll){
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }
       
        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            return abort(403);
        }
        $payroll->delete();
        return redirect('/verifikasi/'.$tagihan->id.'/payroll')->with('berhasil','Data berhasil di Hapus.');
    }

    public function cetakPayroll(tagihan $tagihan){
        if (! Gate::allows('Validator', auth()->user()->id)) {
            abort(403);
        }
       
        if (! Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
            abort(403);
        }

        if ($tagihan->status != 2) {
            return abort(403);
        }

        switch ($tagihan->jnstagihan) {
            case '0':
                $type="SPBy";
                break;
            case '1':
                $type="SPM";
                break;
            case '2':
                $type="KKP";
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
        $spreadsheet    ->setActiveSheetIndex(0)
                        ->setCellValue('B1', 'Payroll '. $type ." ". $tagihan->notagihan)
                        ->mergeCells('B1:I1')
                        ->setCellValue('B2', $tagihan->uraian)
                        ->mergeCells('B2:I2')
                        ->setCellValue('B4', "BNI")
                        ->mergeCells('B4:I4')
                        ;

        $spreadsheet    ->getActiveSheet()
                         ->getStyle('B1:C2')->applyFromArray($textcenter)
        ;
        $spreadsheet    ->getActiveSheet()
                        ->setCellValue('B5', "No.")
                        ->setCellValue('C5', "Nomor Rekening")
                        ->setCellValue('D5', "Nama Penerima")
                        ->setCellValue('E5', "Bruto")
                        ->setCellValue('F5', "Pajak")
                        ->setCellValue('G5', "Biaya Admin")
                        ->setCellValue('H5', "Netto")
                        ->setCellValue('I5', "Bank")
        ;
        $spreadsheet    ->getActiveSheet()
                        ->getStyle('B5:I5')->applyFromArray($textcenter)
        ;
        $i=0;
        foreach ($tagihan->payroll as $payroll) {
            if (Str::upper($payroll->bank) === "BANK NEGARA INDONESIA" || Str::upper($payroll->bank) === "BNI" || Str::upper($payroll->bank) === "BANK NEGARAINDONESIA"|| Str::upper($payroll->bank) === "BANKNEGARA INDONESIA"|| Str::upper($payroll->bank) === "BANKNEGARAINDONESIA") {
                $i++;
                $spreadsheet    ->getActiveSheet()
                                ->setCellValue('B'.($i+5), $i)
                                ->setCellValue('D'.($i+5), $payroll->nama)
                                ->setCellValue('E'.($i+5), $payroll->bruto)
                                ->setCellValue('F'.($i+5), $payroll->pajak)
                                ->setCellValue('G'.($i+5), $payroll->admin)
                                ->setCellValue('H'.($i+5), $payroll->netto)
                                ->setCellValue('I'.($i+5), $payroll->bank)
                ;
                $spreadsheet    ->getActiveSheet()->getCell('C'.($i+5))->setValueExplicit($payroll->norek, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            }
        }
        $spreadsheet    ->getActiveSheet()
                        ->setCellValue('B'.($i+7), "Jumlah")
                        ->setCellValue('E'.($i+7), "=SUM(E5:E".($i+5).")")
                        ->setCellValue('F'.($i+7), "=SUM(F5:F".($i+5).")")
                        ->setCellValue('G'.($i+7), "=SUM(G5:G".($i+5).")")
                        ->setCellValue('H'.($i+7), "=SUM(H5:H".($i+5).")")
                        ->mergeCells('B'.($i+7).':D'.($i+7))
        ;
        $spreadsheet    ->getActiveSheet()
                        ->getStyle('E5:H'.($i+7))->getNumberFormat()->setFormatCode('#,##0.00')
        ;
        $spreadsheet    ->getActiveSheet()->getStyle('B5:I'.($i+7))->applyFromArray($styleBorder);

        $nonBNIcol = $i+9;
        $spreadsheet    ->getActiveSheet()
                        ->setCellValue('B'. $nonBNIcol, "NON BNI")
                        ->mergeCells('B'. $nonBNIcol.':I'. $nonBNIcol)
        ;
        $spreadsheet    ->getActiveSheet()
                        ->setCellValue('B'. $nonBNIcol+1, "No.")
                        ->setCellValue('C'. $nonBNIcol+1, "Nomor Rekening")
                        ->setCellValue('D'. $nonBNIcol+1, "Nama Penerima")
                        ->setCellValue('E'. $nonBNIcol+1, "Bruto")
                        ->setCellValue('F'. $nonBNIcol+1, "Pajak")
                        ->setCellValue('G'. $nonBNIcol+1, "Biaya Admin")
                        ->setCellValue('H'. $nonBNIcol+1, "Netto")
                        ->setCellValue('I'. $nonBNIcol+1, "Bank")
        ;
        $spreadsheet    ->getActiveSheet()
                        ->getStyle('B'.$nonBNIcol+1 .':I'. $nonBNIcol+1)->applyFromArray($textcenter)
        ;
        $j= 0;
        foreach ($tagihan->payroll as $payroll) {
            if (!(Str::upper($payroll->bank) === "BANK NEGARA INDONESIA" || Str::upper($payroll->bank) === "BNI" || Str::upper($payroll->bank) === "BANK NEGARAINDONESIA"|| Str::upper($payroll->bank) === "BANKNEGARA INDONESIA"|| Str::upper($payroll->bank) === "BANKNEGARAINDONESIA")) {
                $j++;
                $spreadsheet    ->getActiveSheet()
                                ->setCellValue('B'.$nonBNIcol+1+$j, $j)
                                ->setCellValue('D'.$nonBNIcol+1+$j, $payroll->nama)

                                ->setCellValue('E'.$nonBNIcol+1+$j, $payroll->bruto)
                                ->setCellValue('F'.$nonBNIcol+1+$j, $payroll->pajak)
                                ->setCellValue('G'.$nonBNIcol+1+$j, $payroll->admin)
                                ->setCellValue('H'.$nonBNIcol+1+$j, $payroll->netto)
                                ->setCellValue('I'.$nonBNIcol+1+$j, $payroll->bank)
                ;
                $spreadsheet    ->getActiveSheet()->getCell('C'.$nonBNIcol+1+$j)->setValueExplicit($payroll->norek, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            }
        }
        $spreadsheet    ->getActiveSheet()
                        ->setCellValue('B'.$nonBNIcol+3+$j, "Jumlah")
                        ->setCellValue('E'.$nonBNIcol+3+$j, "=SUM(E".$nonBNIcol+2 .":E".$nonBNIcol+2+$j.")")
                        ->setCellValue('F'.$nonBNIcol+3+$j, "=SUM(F".$nonBNIcol+2 .":F".$nonBNIcol+2+$j.")")
                        ->setCellValue('G'.$nonBNIcol+3+$j, "=SUM(G".$nonBNIcol+2 .":G".$nonBNIcol+2+$j.")")
                        ->setCellValue('H'.$nonBNIcol+3+$j, "=SUM(H".$nonBNIcol+2 .":H".$nonBNIcol+2+$j.")")
                        ->mergeCells('B'.$nonBNIcol+3+$j.':D'.$nonBNIcol+3+$j)
        ;
        $spreadsheet    ->getActiveSheet()
                        ->getStyle("E".$nonBNIcol+2 .":H".$nonBNIcol+3+$j)->getNumberFormat()->setFormatCode('#,##0.00')
        ;
        $spreadsheet    ->getActiveSheet()->getStyle('B'.$nonBNIcol+1 .":I".$nonBNIcol+3+$j)->applyFromArray($styleBorder);
        foreach ($spreadsheet->getActiveSheet()->getColumnIterator() as $column) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $totalCol =  $nonBNIcol + $j + 6;
        $spreadsheet->getActiveSheet()
            ->setCellValue('E' . $totalCol, "=E" . $nonBNIcol + 3 + $j . "+" . 'E' . ($i + 7))
            ->setCellValue('F' . $totalCol, "=F" . $nonBNIcol + 3 + $j . "+" . 'F' . ($i + 7))
            ->setCellValue('G' . $totalCol, "=G" . $nonBNIcol + 3 + $j . "+" . 'G' . ($i + 7))
            ->setCellValue('H' . $totalCol, "=H" . $nonBNIcol + 3 + $j . "+" . 'H' . ($i + 7));
        $spreadsheet->getActiveSheet()
            ->getStyle("E" . $totalCol . ":H" . $totalCol )->getNumberFormat()->setFormatCode('#,##0.00');
        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Payroll '.$type.' '.$tagihan->notagihan.'-'.date('D, d M Y H:i:s').'.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
}
