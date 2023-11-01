<?php

namespace App\Http\Controllers;

use App\Models\berkas;
use App\Models\Payroll;
use App\Models\tagihan;
use Illuminate\Support\Str;
use App\Models\berkasupload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class PayrollController extends Controller
{
    public function index()
    {
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }

        return view('payroll.index',[
            'data'  => Payroll::BelumTransfer()->paginate(15)->withQueryString()
        ]);
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
            return redirect('/payroll/'.$tagihan->id.'/dokumen')->with('berhasil', 'Dokumen Berhasil Di Upload');
        }

        if ($request->_method === 'DELETE') {
            if ($tagihan->id != $berkas->tagihan_id) {
                abort(403);
            }

            if ($berkas->berkas->kodeberkas === '03' || $berkas->berkas->kodeberkas === '04' || $berkas->berkas->kodeberkas === '05') {
                Storage::delete($berkas->file);
                $berkas->delete();
                return redirect('/payroll/'.$tagihan->id.'/dokumen')->with('berhasil', 'Dokumen Berhasil Di Hapus');
            }else{
                abort(403);
            }
        }

        return view('uploadberkas.upload',[
            'berkas'=>berkas::bendahara()->orderby('kodeberkas')->get(),
            'data'=>$tagihan,
            'back'=>'/payroll/',
            'upload'=>'/payroll/'.$tagihan->id.'/upload',
            
        ]);
    }

    public function dokumen(tagihan $tagihan)
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

        return view('uploadberkas.index',[
            'data'=>$tagihan,
            'back'=>'/payroll',
            'upload'=>'/payroll/'.$tagihan->id.'/upload',
            'delete'=>'/payroll/'.$tagihan->id.'/upload/'
        ]);

    }

    public function approve(tagihan $tagihan)
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
        if (berkasupload::where('tagihan_id', $tagihan->id)->cekberkas5()->first() === null) {
            return back()->with('gagal','Data tidak dapat dikirim karena bukti payroll belum di upload.');
        }
        $tagihan->payroll()->update([
            'status'=>1
        ]);
        return redirect('/payroll')->with('berhasil', 'Data Berhasil Di Approve.');
    }

    public function show(tagihan $tagihan)
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
        return view('payroll.show',[
            'data'=>$tagihan->payroll()->belumApprove()->search()->paginate(15)->withQueryString(),
            'tagihan'=>$tagihan
        ]);
    }

    public function cetak(tagihan $tagihan){
        if (! Gate::allows('Bendahara', auth()->user()->id)) {
            abort(403);
        }
        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }
        if ($tagihan->status != 4) {
            abort(403);
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
        foreach ($tagihan->payroll()->BelumApprove()->get() as $payroll) {
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
        foreach ($tagihan->payroll()->BelumApprove()->get() as $payroll) {
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
