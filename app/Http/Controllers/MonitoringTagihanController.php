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
use App\Models\register_tagihan;
use Illuminate\Support\Facades\Gate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use ZipArchive;
use Illuminate\Support\Facades\Storage;

class MonitoringTagihanController extends Controller
{
    public function index()
    {
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }
        if (Gate::allows('PPK')) {
            $data = tagihan::with(['unit', 'ppk', 'dokumen', 'realisasi'])->tagihanppk()->where('tahun', session()->get('tahun'))->filter()->search()->order()->paginate(15)->withQueryString();
        } else {
            $data = tagihan::with(['unit', 'ppk', 'dokumen', 'realisasi'])->tagihanStafPPK()->where('tahun', session()->get('tahun'))->filter()->search()->order()->paginate(15)->withQueryString();
        }
        return view('monitoring_tagihan.index', [
            'data' => $data,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function show(Request $request, tagihan $monitoring_tagihan)
    {
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if (Gate::allows('PPK')) {
            if ($monitoring_tagihan->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK')) {
            if (!in_array($monitoring_tagihan->ppk_id, session()->get('ppk')) || !in_array($monitoring_tagihan->kodeunit, session()->get('unit')) || $monitoring_tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        }
        switch ($request->scope) {
            case 'dokumen':
                return view('monitoring_tagihan.dokumen', [
                    'data' => berkasupload::with('berkas')->where('tagihan_id', $monitoring_tagihan->id)->get(),
                    'tagihan' => $monitoring_tagihan,
                    'notifikasi' => Notification::Notif()
                ]);
                break;

            case 'histories':
                return view('monitoring_tagihan.detail', [
                    'data' => $monitoring_tagihan->log()->orderBy('created_at', 'desc')->get(),
                    'notifikasi' => Notification::Notif()
                ]);
                break;
        }
    }

    public function showcoa(tagihan $tagihan)
    {
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if (Gate::allows('PPK')) {
            if ($tagihan->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK')) {
            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        }

        return view('monitoring_tagihan.coa', [
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

    // public function showdnp(tagihan $tagihan)
    // {
    //     if (! Gate::allows('PPK')&&! Gate::allows('Staf_PPK')) {
    //         abort(403);
    //     }

    //     if (Gate::allows('PPK')) {
    //         if ($tagihan->ppk_id != auth()->user()->nip) {
    //             abort(403);
    //         }
    //     }

    //     if (Gate::allows('Staf_PPK')) {
    //         if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
    //             abort(403);
    //         }
    //     }
    //     return view('monitoring_tagihan.dnp',[
    //         'data'=>$tagihan->dnp()->search()->paginate(15)->withQueryString(),
    //         'tagihan'=>$tagihan
    //     ]);
    // }

    public function showrekanan(tagihan $tagihan)
    {
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if (Gate::allows('PPK')) {
            if ($tagihan->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK')) {
            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        }
        return view('monitoring_tagihan.rekanan.index', [
            'data' => $tagihan->rekanan()->rekanansatker()->search()->paginate(15)->withQueryString(),
            'tagihan' => $tagihan,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function showppnrekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if (Gate::allows('PPK')) {
            if ($tagihan->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK')) {
            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        }
        return view('monitoring_tagihan.rekanan.ppn.index', [
            'data' => ppnrekanan::myppn($tagihan, $rekanan)->get(),
            'tagihan' => $tagihan,
            'rekanan' => $rekanan,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function showpphrekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if (Gate::allows('PPK')) {
            if ($tagihan->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK')) {
            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        }
        return view('monitoring_tagihan.rekanan.pph.index', [
            'data' => pphrekanan::mypph($tagihan, $rekanan)->with(['objekpajak'])->get(),
            'tagihan' => $tagihan,
            'rekanan' => $rekanan,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function tolak(tagihan $tagihan)
    {
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if ($tagihan->status != 1) {
            return abort(403);
        }

        if (Gate::allows('PPK')) {
            if ($tagihan->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK')) {
            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        }

        $tagihan->update(['status' => 0]);
        register_tagihan::where('tagihan_id', $tagihan->id)->delete();
        return redirect('/monitoring-tagihan');
    }

    public function payroll(tagihan $tagihan)
    {
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if (Gate::allows('PPK')) {
            if ($tagihan->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK')) {
            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        }

        return view('arsip.payroll', [
            'data' => $tagihan->payroll()->search()->paginate(15)->withQueryString(),
            'tagihan' => $tagihan,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function cetakPayroll(tagihan $tagihan)
    {
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if (Gate::allows('PPK')) {
            if ($tagihan->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK')) {
            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
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
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if (Gate::allows('PPK')) {
            if ($tagihan->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK')) {
            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
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
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if (Gate::allows('PPK')) {
            if ($tagihan->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK')) {
            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        }

        ob_start();
        $html = ob_get_clean();
        $html2pdf = new Html2Pdf('L', 'F4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('DNP Perjadin');
        $html2pdf->writeHTML(view('arsip.dnp_perjadin.cetak.dnp', [
            'uraian' => $tagihan->uraian,
            'ppk' => $tagihan->ppk->nama,
            'data' => $tagihan->dnpperjadin()->get()
        ]));
        $html2pdf->output('DNP Perjadin.pdf', 'I');
    }

    public function detailDnpPerjadin(tagihan $tagihan, DnpPerjadin $dnp, Request $request)
    {
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if (Gate::allows('PPK')) {
            if ($tagihan->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK')) {
            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
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
            'notifikasi' => Notification::Notif(),
            'base_url' => $base_url
        ]);
    }

    public function cetakKuitansiPerjadin(tagihan $tagihan, DnpPerjadin $dnp)
    {
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if (Gate::allows('PPK')) {
            if ($tagihan->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK')) {
            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        }

        if ($tagihan->id != $dnp->tagihan_id) {
            abort(403);
        }

        ob_start();
        $html = ob_get_clean();
        $html2pdf = new Html2Pdf('P', 'F4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('DNP Perjadin');
        $html2pdf->writeHTML(view('arsip.dnp_perjadin.cetak.kuitansi', [
            'ppk' => $tagihan->ppk,
            'dnp' => $dnp,
            // 'data'=>$tagihan->dnpperjadin()->get()
        ]));
        $html2pdf->output('DNP Perjadin.pdf', 'I');
    }

    public function dnpHonorarium(tagihan $tagihan, Request $request)
    {
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if (Gate::allows('PPK')) {
            if ($tagihan->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK')) {
            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
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
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if (Gate::allows('PPK')) {
            if ($tagihan->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK')) {
            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        }

        ob_start();
        $html = ob_get_clean();
        $html2pdf = new Html2Pdf('L', 'F4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('DNP Honorarium');
        $html2pdf->writeHTML(view('arsip.dnp_honor.cetak', [
            'uraian' => $tagihan->uraian,
            'ppk' => $tagihan->ppk->nama,
            'data' => $tagihan->dnpHonor()->get()
        ]));
        $html2pdf->output('DNP Perjadin.pdf', 'I');
    }

    public function cetakRekapTagihan()
    {
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if (Gate::allows('PPK')) {
            $data = tagihan::with(['unit', 'ppk', 'berkasupload.berkas', 'realisasi'])->tagihanppk()->where('tahun', session()->get('tahun'))->filter()->search()->order()->paginate(15)->withQueryString();
        } else {
            $data = tagihan::with(['unit', 'ppk', 'berkasupload.berkas', 'realisasi'])->tagihanStafPPK()->where('tahun', session()->get('tahun'))->filter()->search()->order()->paginate(15)->withQueryString();
        }
        $textcenter = [
            'alignment' => [
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ],
        ];

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

        $spreadsheet = new Spreadsheet();
        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setCellValue('A1', 'Rekap Tagihan');
        $sheet->mergeCells('A1:K1');
        $sheet->getStyle('A1')->applyFromArray($textcenter);
        $sheet->getStyle('A1:K1')->applyFromArray($styleBorder);
        $sheet->setCellValue('A2', 'No');
        $sheet->setCellValue('B2', 'Jenis Tagihan');
        $sheet->setCellValue('C2', 'Nomor Tagihan');
        $sheet->setCellValue('D2', 'Tahun');
        $sheet->setCellValue('E2', 'PPK');
        $sheet->setCellValue('F2', 'Unit');
        $sheet->setCellValue('G2', 'Uraian');
        $sheet->setCellValue('H2', 'Bruto');
        $sheet->setCellValue('I2', 'Dokumen');
        $sheet->mergeCells('A2:A3');
        $sheet->mergeCells('B2:B3');
        $sheet->mergeCells('C2:C3');
        $sheet->mergeCells('D2:D3');
        $sheet->mergeCells('E2:E3');
        $sheet->mergeCells('F2:F3');
        $sheet->mergeCells('G2:G3');
        $sheet->mergeCells('H2:H3');
        $sheet->mergeCells('I2:K2');
        $sheet->setCellValue('I3', 'Jenis Dokumen');
        $sheet->setCellValue('J3', 'Keterangan');
        $sheet->setCellValue('K3', 'Link');
        $num_row = 4;
        $num = 1;
        foreach ($data as $item) {
            switch ($item->jnstagihan) {
                case '0':
                    $type = 'SPBy';
                    break;
                case '1':
                    $type = 'SPP';
                    break;
                case '2':
                    $type = 'KKP';
                    break;
                default:
                    $type = '';
            }
            $sheet->setCellValue('A' . $num_row, $num++);
            $sheet->setCellValue('B' . $num_row, $type);
            $sheet->setCellValue('C' . $num_row, $item->notagihan);
            $sheet->setCellValue('D' . $num_row, $item->tahun);
            $sheet->setCellValue('E' . $num_row, optional($item->ppk)->nama);
            $sheet->setCellValue('F' . $num_row, optional($item->unit)->namaunit);
            $sheet->setCellValue('G' . $num_row, $item->uraian);
            $sheet->setCellValue('H' . $num_row, number_format($item->realisasi->sum('realisasi'), 2, ',', '.'));
            $row = 1;
            $row_count = $item->berkasupload->count();
            foreach ($item->berkasupload as $berkas) {
                if (($row_count) == $row) {
                    $sheet->mergeCells('A' . $num_row . ':A' . $num_row + $row - 1);
                    $sheet->mergeCells('B' . $num_row . ':B' . $num_row + $row - 1);
                    $sheet->mergeCells('C' . $num_row . ':C' . $num_row + $row - 1);
                    $sheet->mergeCells('D' . $num_row . ':D' . $num_row + $row - 1);
                    $sheet->mergeCells('E' . $num_row . ':E' . $num_row + $row - 1);
                    $sheet->mergeCells('F' . $num_row . ':F' . $num_row + $row - 1);
                    $sheet->mergeCells('G' . $num_row . ':G' . $num_row + $row - 1);
                    $sheet->mergeCells('H' . $num_row . ':H' . $num_row + $row - 1);
                }

                $sheet->setCellValue('I' . $num_row + $row - 1, optional($berkas->berkas)->namaberkas);
                $sheet->setCellValue('J' . $num_row + $row - 1, $berkas->uraian);
                $sheet->setCellValue('K' . $num_row + $row - 1, "download");
                $sheet->getCell('K' . $num_row + $row - 1)->getHyperlink()->setUrl(env('APP_URL') . "/file-view/" . $berkas->file); // URL tujuan
                $sheet->getStyle('K' . $num_row + $row - 1)->getFont()->getColor()->setARGB('FF0000FF'); // Warna teks biru untuk hyperlink
                $sheet->getStyle('K' . $num_row + $row - 1)->getFont()->setUnderline(true);
                $row++;
            }
            if ($row_count > 0) {
                $num_row += $row_count;
            } else {
                $num_row++;
            }
        }

        $spreadsheet->setActiveSheetIndex(0)->getStyle('A2:K3')->applyFromArray($textcenter);
        $spreadsheet->setActiveSheetIndex(0)->getStyle('A2:K' . ($num_row - 1))->applyFromArray($styleBorder);


        foreach ($spreadsheet->setActiveSheetIndex(0)->getColumnIterator() as $column) {
            $spreadsheet->setActiveSheetIndex(0)->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Rekap Tagihan - ' . date('D, d M Y H:i:s') . '.xlsx"');
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

    public function downloadAll(tagihan $tagihan)
    {
        if (!Gate::allows('PPK') && !Gate::allows('Staf_PPK')) {
            abort(403);
        }

        if (Gate::allows('PPK')) {
            if ($tagihan->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK')) {
            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        }

        $fileUpload = $tagihan->berkasupload()->get();

        $files = [];

        foreach ($fileUpload as $file) {
            $files[] = $file->file;
        }

        switch ($tagihan->jnstagihan) {
            case '0':
                $jenis = "SPBY";
                break;

            case '1':
                $jenis = "SPP";
                break;

            case '2':
                $jenis = "KKP";
                break;

            default:
                $jenis = "";
                break;
        }

        $zipFileName = $jenis . '-' . $tagihan->notagihan . '.zip';
        $zip = new ZipArchive;

        // Membuat file ZIP di dalam storage sementara Laravel
        $zipPath = storage_path($zipFileName);

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            // Menambahkan file ke dalam ZIP
            foreach ($files as $file) {
                if (Storage::exists($file)) {
                    $zip->addFile(Storage::path($file), basename($file));
                }
            }
            $zip->close();
        }

        // Kirim file ZIP sebagai respons untuk diunduh
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}
