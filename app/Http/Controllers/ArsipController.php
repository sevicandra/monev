<?php

namespace App\Http\Controllers;

use App\Models\rekanan;
use App\Models\tagihan;
use App\Models\pphrekanan;
use App\Models\ppnrekanan;
use App\Models\DnpPerjadin;
use Illuminate\Support\Str;
use App\Helper\Notification;
use App\Models\berkasupload;
use Illuminate\Http\Request;
use Spipu\Html2Pdf\Html2Pdf;
use Illuminate\Support\Facades\Gate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class ArsipController extends Controller
{
    public function index()
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
        }

        return view('arsip.index', [
            'data' => tagihan::with(['unit', 'ppk', 'dokumen', 'realisasi'])->tagihansatker()->orderby('notagihan', 'desc')->search()->order()->paginate(15)->withQueryString(),
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function dokumen(tagihan $tagihan)
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('arsip.dokumen', [
            'data' => berkasupload::with('berkas')->where('tagihan_id', $tagihan->id)->get(),
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function coa(tagihan $tagihan)
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('arsip.coa', [
            'data' => $tagihan->realisasi()->with(['pagu'])->searchprogram()
                ->searchkegiatan()
                ->searchkro()
                ->searchro()
                ->searchkomponen()
                ->searchsubkomponen()
                ->searchakun()->paginate(15)->withQueryString(),
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function dnp(tagihan $tagihan)
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('arsip.dnp', [
            'data' => $tagihan->dnp()->search()->paginate(15)->withQueryString(),
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function tolak(tagihan $tagihan)
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->status != 5) {
            abort(403);
        }
        $tagihan->update([
            'status' => 4
        ]);
        return redirect('/arsip')->with('berhasil', 'Tagihan Berhasil Di Tolak');
    }

    public function showrekanan(tagihan $tagihan)
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('arsip.rekanan.index', [
            'data' => $tagihan->rekanan()->rekanansatker()->search()->paginate(15)->withQueryString(),
            'tagihan' => $tagihan,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function showppnrekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('arsip.rekanan.ppn.index', [
            'data' => ppnrekanan::myppn($tagihan, $rekanan)->get(),
            'tagihan' => $tagihan,
            'rekanan' => $rekanan,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function showpphrekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('arsip.rekanan.pph.index', [
            'data' => pphrekanan::mypph($tagihan, $rekanan)->get(),
            'tagihan' => $tagihan,
            'rekanan' => $rekanan,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function showriwayat(tagihan $tagihan)
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('arsip.detail', [
            'data' => $tagihan->log()->orderby('created_at', 'DESC')->get(),
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function payroll(tagihan $tagihan)
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('arsip.payroll',[
            'data' => $tagihan->payroll()->search()->paginate(15)->withQueryString(),
            'tagihan'=>$tagihan,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function cetakPayroll(tagihan $tagihan)
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        switch ($tagihan->jnstagihan) {
            case '0':
                $type = 'SPBy';
                break;
            case '1':
                $type = 'SPM';
                break;
            case '2':
                $type = 'KKP';
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
        $spreadsheet
            ->setActiveSheetIndex(0)
            ->setCellValue('B1', 'Payroll ' . $type . ' ' . $tagihan->notagihan)
            ->mergeCells('B1:I1')
            ->setCellValue('B2', $tagihan->uraian)
            ->mergeCells('B2:I2')
            ->setCellValue('B4', 'BNI')
            ->mergeCells('B4:I4');

        $spreadsheet->getActiveSheet()->getStyle('B1:C2')->applyFromArray($textcenter);
        $spreadsheet->getActiveSheet()->setCellValue('B5', 'No.')->setCellValue('C5', 'Nomor Rekening')->setCellValue('D5', 'Nama Penerima')->setCellValue('E5', 'Bruto')->setCellValue('F5', 'Pajak')->setCellValue('G5', 'Biaya Admin')->setCellValue('H5', 'Netto')->setCellValue('I5', 'Bank');
        $spreadsheet->getActiveSheet()->getStyle('B5:I5')->applyFromArray($textcenter);
        $i = 0;
        foreach ($tagihan->payroll as $payroll) {
            if (Str::upper($payroll->bank) === 'BANK NEGARA INDONESIA' || Str::upper($payroll->bank) === 'BNI' || Str::upper($payroll->bank) === 'BANK NEGARAINDONESIA' || Str::upper($payroll->bank) === 'BANKNEGARA INDONESIA' || Str::upper($payroll->bank) === 'BANKNEGARAINDONESIA') {
                $i++;
                $spreadsheet
                    ->getActiveSheet()
                    ->setCellValue('B' . ($i + 5), $i)
                    ->setCellValue('D' . ($i + 5), $payroll->nama)
                    ->setCellValue('E' . ($i + 5), $payroll->bruto)
                    ->setCellValue('F' . ($i + 5), $payroll->pajak)
                    ->setCellValue('G' . ($i + 5), $payroll->admin)
                    ->setCellValue('H' . ($i + 5), $payroll->netto)
                    ->setCellValue('I' . ($i + 5), $payroll->bank);
                $spreadsheet
                    ->getActiveSheet()
                    ->getCell('C' . ($i + 5))
                    ->setValueExplicit($payroll->norek, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            }
        }
        $spreadsheet
            ->getActiveSheet()
            ->setCellValue('B' . ($i + 7), 'Jumlah')
            ->setCellValue('E' . ($i + 7), '=SUM(E5:E' . ($i + 5) . ')')
            ->setCellValue('F' . ($i + 7), '=SUM(F5:F' . ($i + 5) . ')')
            ->setCellValue('G' . ($i + 7), '=SUM(G5:G' . ($i + 5) . ')')
            ->setCellValue('H' . ($i + 7), '=SUM(H5:H' . ($i + 5) . ')')
            ->mergeCells('B' . ($i + 7) . ':D' . ($i + 7));
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('E5:H' . ($i + 7))
            ->getNumberFormat()
            ->setFormatCode('#,##0.00');
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('B5:I' . ($i + 7))
            ->applyFromArray($styleBorder);

        $nonBNIcol = $i + 9;
        $spreadsheet
            ->getActiveSheet()
            ->setCellValue('B' . $nonBNIcol, 'NON BNI')
            ->mergeCells('B' . $nonBNIcol . ':I' . $nonBNIcol);
        $spreadsheet
            ->getActiveSheet()
            ->setCellValue('B' . $nonBNIcol + 1, 'No.')
            ->setCellValue('C' . $nonBNIcol + 1, 'Nomor Rekening')
            ->setCellValue('D' . $nonBNIcol + 1, 'Nama Penerima')
            ->setCellValue('E' . $nonBNIcol + 1, 'Bruto')
            ->setCellValue('F' . $nonBNIcol + 1, 'Pajak')
            ->setCellValue('G' . $nonBNIcol + 1, 'Biaya Admin')
            ->setCellValue('H' . $nonBNIcol + 1, 'Netto')
            ->setCellValue('I' . $nonBNIcol + 1, 'Bank');
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('B' . $nonBNIcol + 1 . ':I' . $nonBNIcol + 1)
            ->applyFromArray($textcenter);
        $j = 0;
        foreach ($tagihan->payroll as $payroll) {
            if (!(Str::upper($payroll->bank) === 'BANK NEGARA INDONESIA' || Str::upper($payroll->bank) === 'BNI' || Str::upper($payroll->bank) === 'BANK NEGARAINDONESIA' || Str::upper($payroll->bank) === 'BANKNEGARA INDONESIA' || Str::upper($payroll->bank) === 'BANKNEGARAINDONESIA')) {
                $j++;
                $spreadsheet
                    ->getActiveSheet()
                    ->setCellValue('B' . $nonBNIcol + 1 + $j, $j)
                    ->setCellValue('D' . $nonBNIcol + 1 + $j, $payroll->nama)

                    ->setCellValue('E' . $nonBNIcol + 1 + $j, $payroll->bruto)
                    ->setCellValue('F' . $nonBNIcol + 1 + $j, $payroll->pajak)
                    ->setCellValue('G' . $nonBNIcol + 1 + $j, $payroll->admin)
                    ->setCellValue('H' . $nonBNIcol + 1 + $j, $payroll->netto)
                    ->setCellValue('I' . $nonBNIcol + 1 + $j, $payroll->bank);
                $spreadsheet
                    ->getActiveSheet()
                    ->getCell('C' . $nonBNIcol + 1 + $j)
                    ->setValueExplicit($payroll->norek, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING);
            }
        }
        $spreadsheet
            ->getActiveSheet()
            ->setCellValue('B' . $nonBNIcol + 3 + $j, 'Jumlah')
            ->setCellValue('E' . $nonBNIcol + 3 + $j, '=SUM(E' . $nonBNIcol + 2 . ':E' . $nonBNIcol + 2 + $j . ')')
            ->setCellValue('F' . $nonBNIcol + 3 + $j, '=SUM(F' . $nonBNIcol + 2 . ':F' . $nonBNIcol + 2 + $j . ')')
            ->setCellValue('G' . $nonBNIcol + 3 + $j, '=SUM(G' . $nonBNIcol + 2 . ':G' . $nonBNIcol + 2 + $j . ')')
            ->setCellValue('H' . $nonBNIcol + 3 + $j, '=SUM(H' . $nonBNIcol + 2 . ':H' . $nonBNIcol + 2 + $j . ')')
            ->mergeCells('B' . $nonBNIcol + 3 + $j . ':D' . $nonBNIcol + 3 + $j);
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('E' . $nonBNIcol + 2 . ':H' . $nonBNIcol + 3 + $j)
            ->getNumberFormat()
            ->setFormatCode('#,##0.00');
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('B' . $nonBNIcol + 1 . ':I' . $nonBNIcol + 3 + $j)
            ->applyFromArray($styleBorder);
        foreach ($spreadsheet->getActiveSheet()->getColumnIterator() as $column) {
            $spreadsheet->getActiveSheet()->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $totalCol = $nonBNIcol + $j + 6;
        $spreadsheet
            ->getActiveSheet()
            ->setCellValue('E' . $totalCol, '=E' . $nonBNIcol + 3 + $j . '+' . 'E' . ($i + 7))
            ->setCellValue('F' . $totalCol, '=F' . $nonBNIcol + 3 + $j . '+' . 'F' . ($i + 7))
            ->setCellValue('G' . $totalCol, '=G' . $nonBNIcol + 3 + $j . '+' . 'G' . ($i + 7))
            ->setCellValue('H' . $totalCol, '=H' . $nonBNIcol + 3 + $j . '+' . 'H' . ($i + 7));
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('E' . $totalCol . ':H' . $totalCol)
            ->getNumberFormat()
            ->setFormatCode('#,##0.00');
        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Payroll ' . $type . ' ' . $tagihan->notagihan . '-' . date('D, d M Y H:i:s') . '.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit();
    }

    public function dnpPerjadin(tagihan $tagihan, Request $request)
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }
        
        $currentPath = $request->path();
        $parts = explode('/', $currentPath);
        $base_url = '/' . $parts[0];
        return view('arsip.dnp_perjadin.index', [
            'tagihan' => $tagihan,
            'data' => $tagihan->dnpperjadin()->search()->paginate(15),
            'notifikasi' => Notification::Notif(),
            'base_url' => $base_url
        ]);
    }

    public function cetakDnpPerjadin(tagihan $tagihan)
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        ob_start();
        $html = ob_get_clean();
        $html2pdf = new Html2Pdf('L', 'F4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('DNP Perjadin');
        $html2pdf->writeHTML(view('arsip.dnp_perjadin.cetak.dnp',[
            'uraian'=>$tagihan->uraian,
            'ppk'=>$tagihan->ppk->nama,
            'data'=>$tagihan->dnpperjadin()->get()
        ]));
        $html2pdf->output('DNP Perjadin.pdf', 'I');
    }

    public function detailDnpPerjadin(tagihan $tagihan, DnpPerjadin $dnp, Request $request)
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->id != $dnp->tagihan_id) {
            abort(403);
        }
        $currentPath = $request->path();
        $parts = explode('/', $currentPath);
        $base_url = '/' . $parts[0];
        return view('arsip.dnp_perjadin.detail.index', [
            'dnp' => $dnp,
            'tagihan' => $tagihan,
            'notifikasi'=>Notification::Notif(),
            'base_url' => $base_url
        ]);
    }

    public function cetakKuitansiPerjadin(tagihan $tagihan, DnpPerjadin $dnp)
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($tagihan->id != $dnp->tagihan_id) {
            abort(403);
        }

        ob_start();
        $html = ob_get_clean();
        $html2pdf = new Html2Pdf('P', 'F4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('DNP Perjadin');
        $html2pdf->writeHTML(view('arsip.dnp_perjadin.cetak.kuitansi',[
            'ppk'=>$tagihan->ppk,
            'dnp'=>$dnp,
            // 'data'=>$tagihan->dnpperjadin()->get()
        ]));
        $html2pdf->output('DNP Perjadin.pdf', 'I');
    }

    public function dnpHonorarium(tagihan $tagihan, Request $request)
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        $currentPath = $request->path();
        $parts = explode('/', $currentPath);
        $base_url = '/' . $parts[0];
        return view('arsip.dnp_honor.index', [
            'tagihan' => $tagihan,
            'data' => $tagihan->dnpHonor()->search()->get(),
            'notifikasi' => Notification::Notif(),
            'base_url' => $base_url
        ]);
    }

    public function cetakDnpHonorarium(tagihan $tagihan)
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
        }

        if ($tagihan->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        ob_start();
        $html = ob_get_clean();
        $html2pdf = new Html2Pdf('L', 'F4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('DNP Honorarium');
        $html2pdf->writeHTML(view('arsip.dnp_honor.cetak',[
            'uraian'=>$tagihan->uraian,
            'ppk'=>$tagihan->ppk->nama,
            'data'=>$tagihan->dnpHonor()->get()
        ]));
        $html2pdf->output('DNP Perjadin.pdf', 'I');
    }
}
