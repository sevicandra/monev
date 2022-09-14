<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\pphrekanan;
use App\Models\ppnrekanan;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class LaporanPajakController extends Controller
{
    public function index()
    {
        if (! Gate::any(['Bendahara', 'PPSPM', 'Validator'], auth()->user()->id)) {
            abort(403);
        }
        return view('laporan_pajak.index');
    }

    public function showpph()
    {
        if (! Gate::any(['Bendahara', 'PPSPM', 'Validator'], auth()->user()->id)) {
            abort(403);
        }
        return view('laporan_pajak.pph',[
            'data'=>pphrekanan::Pphunit()->tahunpajak()->masapajak()->get()
        ]);
    }

    public function cetakpph()
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load('xlsx/Laporan_PPh.xlsx');
        $row=4;
        foreach (pphrekanan::Pphunit()->tahunpajak()->masapajak()->get()as $key) {
            $A=$row-3;
            if ($key->tagihan->jnstagihan === '1') {
                $B=$key->tagihan->notagihan;
            }else{
                $B=null;
            }
            if ($key->tagihan->jnstagihan === '0') {
                $C=$key->tagihan->notagihan;
            }else{
                $C=null;
            }
            if ($key->tagihan->jnstagihan === '1') {
                if ($key->tagihan->spm) {
                    $D=$key->tagihan->spm->nomor_sp2d;
                    $E=$key->tagihan->spm->tanggal_sp2d;
                }else{
                    $D=null;
                    $E=null;
                }
            }else{
                $D=$key->ntpn;
                $E=$key->tanggalntpn;
            }
            

            if ($key->rekanan->npwp === 1) {
                $F='NPWP';
                $G=$key->rekanan->idpajak;
                $H=null;
                $K=$key->objekpajak->tarif;
                $L=$key->pph;
                $M=$key->pph/($key->objekpajak->tarif/100);
                $N=$key->pph/($key->objekpajak->tarif/100);
            }else{
                $F='NIK';
                $G=null;
                $H=$key->rekanan->idpajak;
                $K=$key->objekpajak->tarifnonnpwp;
                $L=$key->pph;
                $M=$key->pph/($key->objekpajak->tarifnonnpwp/100);
                $N=$key->pph/($key->objekpajak->tarifnonnpwp/100);
            }
            $I=$key->rekanan->nama;
            $J=$key->objekpajak->kode;
            $spreadsheet->getActiveSheet()  ->setCellValue('A' . $row, $A)
                                            ->setCellValue('B' . $row, "'".$B)
                                            ->setCellValue('C' . $row, "'".$C)
                                            ->setCellValue('D' . $row, "'".$D)
                                            ->setCellValue('E' . $row, $E)
                                            ->setCellValue('F' . $row, $F)
                                            ->setCellValue('G' . $row, "'".$G)
                                            ->setCellValue('H' . $row, "'".$H)
                                            ->setCellValue('I' . $row, $I)
                                            ->setCellValue('J' . $row, $J)
                                            ->setCellValue('K' . $row, $K.'%')
                                            ->setCellValue('L' . $row, $L)
                                            ->setCellValue('M' . $row, $M)
                                            ->setCellValue('N' . $row, $N)
            ;
            $row++;
        }
        $uuid=Str::uuid()->toString();
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('xlsx/laporan_pph/Laporan_PPh-'.$uuid.'.xlsx');
        return response()->download(file: 'xlsx/laporan_pph/Laporan_PPh-'.$uuid.'.xlsx')->deleteFileAfterSend(shouldDelete: true);
    }

    public function showppn()
    {
        if (! Gate::any(['Bendahara', 'PPSPM', 'Validator'], auth()->user()->id)) {
            abort(403);
        }
        return view('laporan_pajak.ppn',[
            'data'=>ppnrekanan::Ppnunit()->tahunpajak()->masapajak()->get()
        ]);
    }

    public function cetakppn()
    {
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load('xlsx/Laporan_PPN.xlsx');
        $row=4;
        foreach (ppnrekanan::Ppnunit()->tahunpajak()->masapajak()->get() as $key) {
            $A=$row-3;
            if ($key->tagihan->jnstagihan === '1') {
                $B=$key->tagihan->notagihan;
            }else{
                $B=null;
            }
            if ($key->tagihan->jnstagihan === '0') {
                $C=$key->tagihan->notagihan;
            }else{
                $C=null;
            }
            if ($key->tagihan->jnstagihan === '1') {
                if ($key->tagihan->spm) {
                    $D=$key->tagihan->spm->nomor_sp2d;
                    $E=$key->tagihan->spm->tanggal_sp2d;
                }else{
                    $D=null;
                    $E=null;
                }
            }else{
                $D=$key->ntpn;
                $E=$key->tanggalntpn;
            }
            
            $F=$key->rekanan->idpajak;
            $G=$key->rekanan->nama;
            $H=$key->nomorfaktur;
            $I=$key->tanggalfaktur;
            $J=Carbon::parse($key->tanggalfaktur)->isoFormat('M');
            $K=$key->tarif*100;
            $L=$key->ppn;
            $M=$key->ppn/($key->tarif);
            $N=$key->ppn/($key->tarif);
            $spreadsheet->getActiveSheet()  ->setCellValue('A' . $row, $A)
                                            ->setCellValue('B' . $row, "'".$B)
                                            ->setCellValue('C' . $row, "'".$C)
                                            ->setCellValue('D' . $row, "'".$D)
                                            ->setCellValue('E' . $row, $E)
                                            ->setCellValue('F' . $row, "'".$F)
                                            ->setCellValue('G' . $row, $G)
                                            ->setCellValue('H' . $row, "'".$H)
                                            ->setCellValue('I' . $row, $I)
                                            ->setCellValue('J' . $row, $J)
                                            ->setCellValue('K' . $row, $K.'%')
                                            ->setCellValue('L' . $row, $L)
                                            ->setCellValue('M' . $row, $M)
                                            ->setCellValue('N' . $row, $N)
            ;
            $row++;
        }
        $uuid=Str::uuid()->toString();
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('xlsx/laporan_ppn/Laporan_PPN-'.$uuid.'.xlsx');
        return response()->download(file: 'xlsx/laporan_ppn/Laporan_PPN-'.$uuid.'.xlsx')->deleteFileAfterSend(shouldDelete: true);
    }
}
