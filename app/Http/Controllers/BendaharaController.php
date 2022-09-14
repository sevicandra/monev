<?php

namespace App\Http\Controllers;

use App\Models\spm;
use App\Models\sspb;
use App\Models\berkas;
use App\Models\rekanan;
use App\Models\tagihan;
use App\Models\realisasi;
use App\Models\logtagihan;
use App\Models\objekpajak;
use App\Models\pphrekanan;
use App\Models\ppnrekanan;
use App\Models\berkasupload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class BendaharaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        return view('bendahara.index',[
           'data'=>tagihan::tagihansatker()->tagihansatker()->bendahara()->get() 
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
    public function show(tagihan $bendahara)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($bendahara->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('bendahara.detail',[
            'data'=>$bendahara
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function edit(tagihan $tagihan)
    {
        //
    }

    public function editsp2d(tagihan $tagihan)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 4) {
            abort(403);
        }
        return view('bendahara.sp2d',[
            'data'=>$tagihan
        ]);
    }

    public function editsspb(tagihan $tagihan, realisasi $realisasi)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->status != 4) {
            abort(403);
        }
        return view('bendahara.sspb',[
            'tagihan'=>$tagihan,
            'realisasi'=>$realisasi
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tagihan $tagihan)
    {
        //
    }

    public function updatesp2d(Request $request, tagihan $tagihan)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 4) {
            abort(403);
        }

        $request->validate([
            'tanggal_spm'=>'required',
            'tanggal_sp2d'=>'required',
            'nomor_sp2d'=>'required|min:15|max:15'
        ]);

        $request->validate([
            'nomor_sp2d'=>'numeric'
        ]);

        if (isset($tagihan->spm)) {
            $tagihan->spm->update([
                'tanggal_spm'=>$request->tanggal_spm,
                'tanggal_sp2d'=>$request->tanggal_sp2d,
                'nomor_sp2d'=>$request->nomor_sp2d
            ]);
            return redirect('/bendahara')->with('berhasil', 'Data SP2D Berhasi Ditambahkan');
        }else{
            spm::create([
                'tagihan_id'=>$tagihan->id,
                'tanggal_spm'=>$request->tanggal_spm,
                'tanggal_sp2d'=>$request->tanggal_sp2d,
                'nomor_sp2d'=>$request->nomor_sp2d
            ]);
            return redirect('/bendahara')->with('berhasil', 'Data SP2D Berhasi Ditambahkan');
        }
    }

    public function updatesspb(Request $request, tagihan $tagihan, realisasi $realisasi)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 4) {
            abort(403);
        }

        $request->validate([
            'tanggal_sspb'=>'required',
            'nominal_sspb'=>'required|numeric'
        ]);

        if ($realisasi->realisasi < $request->nominal_sspb) {
            return back()->with('gagal','Nilai SSPB Lebih besar dari realisasi'); 
        }
        
        if (isset($realisasi->sspb)) {
            $realisasi->sspb->update([
                'tanggal_sspb'=>$request->tanggal_sspb,
                'nominal_sspb'=>$request->nominal_sspb,
            ]);
            return redirect('/bendahara/'.$tagihan->id)->with('berhasil', 'Data SSPB Berhasi Ditambahkan');
        }else{
            sspb::create([
                'realisasi_id'=>$realisasi->id,
                'pagu_id'=>$realisasi->pagu->id,
                'nominal_sspb'=>$request->nominal_sspb,
                'tanggal_sspb'=>$request->tanggal_sspb,
            ]);
            return redirect('/bendahara/'.$tagihan->id)->with('berhasil', 'Data SSPB Berhasi Ditambahkan');
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
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 4) {
            abort(403);
        }
        $tagihan->spm->delete();
        $tagihan->update([
            'status'=>2
        ]);
        logtagihan::create([
            'tagihan_id'=>$tagihan->id,
            'action'=>'Tolak',
            'user'=>auth()->user()->nama,
            'catatan'=>''
        ]);
        return redirect('/bendahara')->with('berhasil', 'Tagihan Berhasil Di Tolak');
    }

    public function approve(tagihan $tagihan){
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 4) {
            abort(403);
        }

        if (!isset($tagihan->spm)) {
            return back()->with('gagal','Data tidak dapat dikirim karena SPM belum di input');
        }

        if ($tagihan->spm->tanggal_sp2d === null || $tagihan->spm->nominal_sp2d) {
            return back()->with('gagal','Data tidak dapat dikirim karena SP2D belum di input');
        }

        switch ($tagihan->jnstagihan) {
            case 0:
                switch ($tagihan->dokumen->statusdnp) {
                    case '1':
                        if (berkasupload::where('tagihan_id', $tagihan->id)->cekberkas5()->first() === null) {
                            return back()->with('gagal','Data tidak dapat dikirim karena berkas belum lengkap.');
                        }
                        $tagihan->update([
                            'status'=>5
                        ]);
                        logtagihan::create([
                            'tagihan_id'=>$tagihan->id,
                            'action'=>'Approve',
                            'user'=>auth()->user()->nama,
                            'catatan'=>''
                        ]);
                        return redirect('/bendahara')->with('berhasil', 'Tagihan Berhasil Di Approve');
                        break;
                    
                    default:
                        $tagihan->update([
                            'status'=>5
                        ]);
                        logtagihan::create([
                            'tagihan_id'=>$tagihan->id,
                            'action'=>'Approve',
                            'user'=>auth()->user()->nama,
                            'catatan'=>''
                        ]);
                        return redirect('/bendahara')->with('berhasil', 'Tagihan Berhasil Di Approve');
                        break;
                }

                break;

            case 1:
                $tagihan->update([
                    'status'=>5
                ]);
                return redirect('/bendahara');
                break;
        }
    }

    public function payroll(tagihan $tagihan)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('bendahara.payroll',[
            'data'=>$tagihan
        ]);
    }

    public function cetakpayroll(tagihan $tagihan)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A4', 'no');
        $sheet->setCellValue('B4', 'nama');
        $sheet->setCellValue('C4', 'nominal');
        $sheet->setCellValue('D4', 'rekening');
        $sheet->setCellValue('E4', 'nmbank');


        $no = 1;
        $i = 5;
        foreach ($tagihan->dnp as $r) {
            $sheet->setCellValue('A' . $i, $no++);
            $sheet->setCellValue('B' . $i, ' ' . $r->namarekening);
            $sheet->setCellValue('C' . $i, $r->nominal->netto);
            $sheet->setCellValue('D' . $i, $r->rekening);
            $sheet->setCellValue('E' . $i, $r->namabank);
            $i++;
        }

        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ],
            ],
        ];
        $i = $i - 1;
        $sheet->getStyle('A4:E' . $i)->applyFromArray($styleArray);
        // simpan datanya
        $date = date('d-m-y-' . substr((string)microtime(), 1, 8));
        $date = str_replace(".", "", $date);
        $filename = "payroll_" . $date . ".xlsx";
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('payroll/'.$filename);
        return response()->download(file: 'payroll/' . $filename)->deleteFileAfterSend(shouldDelete: true);
    }

    public function upload(Request $request, tagihan $tagihan, berkasupload $berkas)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 4) {
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
            return redirect('/bendahara/'.$tagihan->id.'/dokumen')->with('berhasil', 'Dokumen Berhasil Di Upload');
        }

        if ($request->_method === 'DELETE') {
            if ($tagihan->id != $berkas->tagihan_id) {
                abort(403);
            }

            if ($berkas->berkas->kodeberkas === '03' || $berkas->berkas->kodeberkas === '04' || $berkas->berkas->kodeberkas === '05') {
                Storage::delete($berkas->file);
                $berkas->delete();
                return redirect('/bendahara/'.$tagihan->id.'/dokumen')->with('berhasil', 'Dokumen Berhasil Di Hapus');
            }else{
                abort(403);
            }
        }

        return view('uploadberkas.upload',[
            'berkas'=>berkas::bendahara()->orderby('kodeberkas')->get(),
            'data'=>$tagihan,
            'back'=>'/bendahara/',
            'upload'=>'/bendahara/'.$tagihan->id.'/upload',
            
        ]);
    }

    public function dokumen(tagihan $tagihan){
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 4) {
            abort(403);
        }

        return view('uploadberkas.index',[
            'data'=>$tagihan,
            'back'=>'/bendahara',
            'upload'=>'/bendahara/'.$tagihan->id.'/upload',
            'delete'=>'/bendahara/'.$tagihan->id.'/upload/'
        ]);

    }

    public function showrekanan(tagihan $tagihan)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 4) {
            abort(403);
        }
        return view('bendahara.rekanan.index',[
            'data'=>$tagihan
        ]);
    }

    public function createrekanan(tagihan $tagihan)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 4) {
            abort(403);
        }
        return view('bendahara.rekanan.create',[
            'tagihan'=>$tagihan,
            'data'=>rekanan::ofTagihan($tagihan->id)
        ]);
    }

    public function storerekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 4) {
            abort(403);
        }
        $tagihan->rekanan()->attach($rekanan->id);

        return redirect('/bendahara/'.$tagihan->id.'/rekanan')->with('berhasil','Data berhasil Ditambahkan.');
    }

    public function deleterekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 4) {
            abort(403);
        }
        $tagihan->rekanan()->detach($rekanan->id);
        pphrekanan::where('rekanan_id', $rekanan->id)->where('tagihan_id', $tagihan->id)->delete();
        ppnrekanan::where('rekanan_id', $rekanan->id)->where('tagihan_id', $tagihan->id)->delete();
        return redirect('/bendahara/'.$tagihan->id.'/rekanan')->with('berhasil','Data berhasil di Hapus.');
    }

    public function showppnrekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 4) {
            abort(403);
        }
        return view('bendahara.rekanan.ppn.index',[
            'data'=>ppnrekanan::myppn($tagihan, $rekanan)->get(),
            'tagihan'=>$tagihan,
            'rekanan'=>$rekanan
        ]);
    }

    public function createppnrekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 4) {
            abort(403);
        }
        return view('bendahara.rekanan.ppn.create',[
            'data'=>ppnrekanan::myppn($tagihan, $rekanan)->get(),
            'tagihan'=>$tagihan,
            'rekanan'=>$rekanan
        ]);
    }

    public function storeppnrekanan(tagihan $tagihan, rekanan $rekanan, Request $request)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 4) {
            abort(403);
        }
        $request->validate([
            'nomorfaktur'=>'required',
            'tanggalfaktur'=>'required',
            'tarif'=>'required',
            'ppn'=>'required|numeric'
        ]);

        if (isset($request->ntpn)) {
            $request->validate([
                'ntpn'=>'min:16|max:16',
                'tanggalntpn'=>'required'
            ]);
        }

        ppnrekanan::create([
            'nomorfaktur'=>$request->nomorfaktur,
            'tanggalfaktur'=>$request->tanggalfaktur,
            'tarif'=>$request->tarif,
            'ppn'=>$request->ppn,
            'tagihan_id'=>$tagihan->id,
            'rekanan_id'=>$rekanan->id,
            'ntpn'=>$request->ntpn,
            'tanggalntpn'=>$request->tanggalntpn,
        ]);

        return redirect('/bendahara/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/ppn')->with('berhasil','Data berhasil Ditambahkan.');
    }


    public function editppnrekanan(tagihan $tagihan, rekanan $rekanan, ppnrekanan $ppn)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 4) {
            abort(403);
        }
        return view('bendahara.rekanan.ppn.update',[
            'tagihan'=>$tagihan,
            'rekanan'=>$rekanan,
            'data'=>$ppn
        ]);
    }

    public function updateppnrekanan(tagihan $tagihan, rekanan $rekanan, ppnrekanan $ppn, Request $request)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 4) {
            abort(403);
        }
        $request->validate([
            'nomorfaktur'=>'required',
            'tanggalfaktur'=>'required',
            'tarif'=>'required',
            'ppn'=>'required|numeric'
        ]);

        if (isset($request->ntpn)) {
            $request->validate([
                'ntpn'=>'min:16|max:16',
                'tanggalntpn'=>'required'
            ]);
        }

        $ppn->update([
            'nomorfaktur'=>$request->nomorfaktur,
            'tanggalfaktur'=>$request->tanggalfaktur,
            'tarif'=>$request->tarif,
            'ppn'=>$request->ppn,
            'ntpn'=>$request->ntpn,
            'tanggalntpn'=>$request->tanggalntpn,
        ]);
        return redirect('/bendahara/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/ppn')->with('berhasil','Data berhasil di Ubah.');
    }

    public function deleteppnrekanan(tagihan $tagihan, rekanan $rekanan, ppnrekanan $ppn)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 4) {
            abort(403);
        }
        if ($ppn->rekanan_id === $rekanan->id && $ppn->tagihan_id === $tagihan->id) {
            $ppn->delete();
            return redirect('/bendahara/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/ppn')->with('berhasil','Data berhasil di Hapus.');
        }else{
            return redirect('/bendahara/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/ppn')->with('gagal','Link Error.');
        }
    }

    public function showpphrekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 4) {
            abort(403);
        }
        return view('bendahara.rekanan.pph.index',[
            'data'=>pphrekanan::mypph($tagihan, $rekanan)->get(),
            'tagihan'=>$tagihan,
            'rekanan'=>$rekanan
        ]);
    }

    public function createpphrekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 4) {
            abort(403);
        }
        return view('bendahara.rekanan.pph.create',[
            'data'=>pphrekanan::mypph($tagihan, $rekanan)->get(),
            'tagihan'=>$tagihan,
            'rekanan'=>$rekanan,
            'objekpajak'=>objekpajak::all()
        ]);
    }

    public function storepphrekanan(tagihan $tagihan, rekanan $rekanan, Request $request)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 4) {
            abort(403);
        }

        $request->validate([
            'objek'=>'required',
            'pph'=>'required|numeric',
        ]);

        if (isset($request->ntpn)) {
            $request->validate([
                'ntpn'=>'min:16|max:16',
                'tanggalntpn'=>'required'
            ]);
        }

        pphrekanan::create([
            'objekpajak_id'=>$request->objek,
            'pph'=>$request->pph,
            'tagihan_id'=>$tagihan->id,
            'rekanan_id'=>$rekanan->id,
            'ntpn'=>$request->ntpn,
            'tanggalntpn'=>$request->tanggalntpn,
        ]);

        return redirect('/bendahara/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/pph')->with('berhasil','Data berhasil Ditambahkan.');
    }


    public function editpphrekanan(tagihan $tagihan, rekanan $rekanan, pphrekanan $pph)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 4) {
            abort(403);
        }
        return view('bendahara.rekanan.pph.update',[
            'tagihan'=>$tagihan,
            'rekanan'=>$rekanan,
            'data'=>$pph,
            'objekpajak'=>objekpajak::all()
        ]);
    }

    public function updatepphrekanan(tagihan $tagihan, rekanan $rekanan, pphrekanan $pph, Request $request)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 4) {
            abort(403);
        }
        $request->validate([
            'objek'=>'required',
            'pph'=>'required|numeric',
        ]);

        if (isset($request->ntpn)) {
            $request->validate([
                'ntpn'=>'min:16|max:16',
                'tanggalntpn'=>'required'
            ]);
        }


        $pph->update([
            'objekpajak_id'=>$request->objek,
            'pph'=>$request->pph,
            'ntpn'=>$request->ntpn,
            'tanggalntpn'=>$request->tanggalntpn,
        ]);
        return redirect('/bendahara/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/pph')->with('berhasil','Data berhasil di Ubah.');
    }

    public function deletepphrekanan(tagihan $tagihan, rekanan $rekanan, pphrekanan $pph)
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 4) {
            abort(403);
        }
        if ($pph->rekanan_id === $rekanan->id && $pph->tagihan_id === $tagihan->id) {
            $pph->delete();
            return redirect('/bendahara/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/pph')->with('berhasil','Data berhasil di Hapus.');
        }else{
            return redirect('/bendahara/'.$tagihan->id.'/rekanan/'. $rekanan->id.'/pph')->with('gagal','Link Error.');
        }
    }
}
