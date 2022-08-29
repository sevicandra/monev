<?php

namespace App\Http\Controllers;

use App\Models\spm;
use App\Models\sspb;
use App\Models\berkas;
use App\Models\tagihan;
use App\Models\realisasi;
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
                        return redirect('/bendahara')->with('berhasil', 'Tagihan Berhasil Di Approve');
                        break;
                    
                    default:
                        $tagihan->update([
                            'status'=>5
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
}
