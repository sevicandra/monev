<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\pphrekanan;
use App\Models\ppnrekanan;
use Illuminate\Support\Str;
use App\Helper\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;

class LaporanPajakController extends Controller
{
    public function index()
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
        }
        return view('laporan_pajak.index', [
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function showpph()
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
        }
        return view('laporan_pajak.pph', [
            'data' => pphrekanan::with(['tagihan', 'rekanan', 'objekpajak'])->Pphunit()->tahunpajak()->masapajak()->get(),
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function cetakpph()
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
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
        $spreadsheet->getActiveSheet(0)
            ->setTitle('Laporan PPh');
        $spreadsheet->getActiveSheet(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'SPM')
            ->setCellValue('C1', 'SPBy')
            ->setCellValue('D1', 'NTPN/SP2D')
            ->setCellValue('E1', 'Tgl NTPN/SP2D (dd/MM/yyyy)')
            ->setCellValue('F1', 'Penerima Penghasilan? (NPWP/NIK)')
            ->setCellValue('G1', 'NPWP (tanpa format/tanda baca)')
            ->setCellValue('H1', 'NIK (tanpa format/tanda baca)')
            ->setCellValue('I1', 'Nama Penerima Penghasilan Sesuai NIK/NPWP')
            ->setCellValue('J1', 'Kode Objek Pajak')
            ->setCellValue('K1', 'Tarif')
            ->setCellValue('L1', 'PPh 23')
            ->setCellValue('M1', 'NOP')
            ->setCellValue('N1', 'Penghasilan Bruto');
        $row = 2;
        $no = 1;
        foreach (pphrekanan::with(['tagihan', 'rekanan', 'objekpajak'])->Pphunit()->tahunpajak()->masapajak()->get() as $key) {
            if ($key->tagihan->jnstagihan === '1') {
                $B = $key->tagihan->notagihan;
            } else {
                $B = null;
            }
            if ($key->tagihan->jnstagihan === '0') {
                $C = $key->tagihan->notagihan;
            } else {
                $C = null;
            }
            if ($key->tagihan->jnstagihan === '1') {
                if ($key->tagihan->nomor_sp2d !== null) {
                    $D = $key->tagihan->nomor_sp2d;
                    $E = $key->tagihan->tanggal_sp2d;
                } else {
                    $D = null;
                    $E = null;
                }
            } else {
                $D = $key->ntpn;
                $E = $key->tanggalntpn ?? null;
            }
            if ($key->rekanan->npwp === 1) {
                $F = 'NPWP';
                $G = $key->rekanan->idpajak;
                $H = null;
                $K = $key->tarif;
                $L = floor($key->pph * ($key->tarif / 100));
                $M = $key->pph;
                $N = $key->pph;
            } else {
                $F = 'NIK';
                $G = null;
                $H = $key->rekanan->idpajak;
                $K = $key->tarif;
                $L = floor($key->pph * ($key->tarif / 100));
                $M = $key->pph;
                $N = $key->pph;
            }
            $I = $key->rekanan->nama;
            $J = $key->objekpajak->kode;
            $spreadsheet->getActiveSheet()->setCellValue('A' . $row, $no++)
                ->setCellValue('B' . $row, $B)
                ->setCellValue('C' . $row, $C)
                ->setCellValue('F' . $row, $F)
                ->setCellValue('I' . $row, $I)
                ->setCellValue('J' . $row, $J)
                ->setCellValue('K' . $row, $K . '%')
                ->setCellValue('L' . $row, $L)
                ->setCellValue('M' . $row, $M)
                ->setCellValue('N' . $row, $N);
                $spreadsheet->getActiveSheet()->getCell('D' . $row)->setValueExplicit($D, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $spreadsheet->getActiveSheet()->getCell('G' . $row)->setValueExplicit($G, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $spreadsheet->getActiveSheet()->getCell('H' . $row)->setValueExplicit($H, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                if ($E) {
                    $spreadsheet->getActiveSheet()->getCell('E' . $row)->setValueExplicit($E, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_ISO_DATE);
                }

            $row++;
        }
        $spreadsheet->setActiveSheetIndex(0)->getStyle('A:N')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
        $spreadsheet->setActiveSheetIndex(0)->getStyle('E:E')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
        $spreadsheet->setActiveSheetIndex(0)->getStyle('K:K')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_00);
        $spreadsheet->setActiveSheetIndex(0)->getStyle('L:N')->getNumberFormat()->setFormatCode('Rp* #,##0.00');
        $spreadsheet->setActiveSheetIndex(0)->getStyle('A1:N1')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
        $spreadsheet->getActiveSheet()
        ->getStyle('A1:N1')
        ->applyFromArray($textcenter);
        $spreadsheet->getActiveSheet()
        ->getStyle('A1:N'.$row)
        ->applyFromArray($styleBorder);
        foreach ($spreadsheet->setActiveSheetIndex(0)->getColumnIterator() as $column) {
            $spreadsheet->setActiveSheetIndex(0)->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="PPH - ' . date('D, d M Y H:i:s') . '.xlsx"');
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

    public function showppn()
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
        }
        return view('laporan_pajak.ppn', [
            'data' => ppnrekanan::with(['tagihan'])->Ppnunit()->tahunpajak()->masapajak()->get(),
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function cetakppn()
    {
        if (!Gate::any(['Bendahara', 'PPSPM', 'Validator'])) {
            abort(403);
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
        $spreadsheet->getActiveSheet(0)
            ->setTitle('Laporan PPh');
        $spreadsheet->getActiveSheet(0)
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'SPM')
            ->setCellValue('C1', 'SPBy')
            ->setCellValue('D1', 'NTPN/SP2D')
            ->setCellValue('E1', 'Tgl NTPN/SP2D (dd/MM/yyyy)')
            ->setCellValue('F1', 'NPWP (tanpa format/tanda baca)')
            ->setCellValue('G1', 'Nama Penerima Penghasilan Sesuai NIK/NPWP')
            ->setCellValue('H1', 'Nomor Faktur Pajak')
            ->setCellValue('I1', 'Tanggal Faktur')
            ->setCellValue('J1', 'Month')
            ->setCellValue('K1', 'Tarif 11% / 1% (TIKI)')
            ->setCellValue('L1', 'PPN')
            ->setCellValue('M1', 'NOP')
            ->setCellValue('N1', 'Penghasilan Bruto');
        $row = 2;
        $no = 1;
        foreach (ppnrekanan::with(['tagihan'])->Ppnunit()->tahunpajak()->masapajak()->get() as $key) {
            if ($key->tagihan->jnstagihan === '1') {
                $B = $key->tagihan->notagihan;
            } else {
                $B = null;
            }
            if ($key->tagihan->jnstagihan === '0') {
                $C = $key->tagihan->notagihan;
            } else {
                $C = null;
            }
            if ($key->tagihan->jnstagihan === '1') {
                if ($key->tagihan->nomor_sp2d != null) {
                    $D = $key->tagihan->nomor_sp2d;
                    $E = $key->tagihan->tanggal_sp2d;
                } else {
                    $D = null;
                    $E = null;
                }
            } else {
                $D = $key->ntpn;
                $E = $key->tanggalntpn ?? null;
            }

            $F = $key->rekanan->idpajak;
            $G = $key->rekanan->nama;
            $H = $key->nomorfaktur;
            $I = $key->tanggalfaktur;
            $J = Carbon::parse($key->tanggalfaktur)->isoFormat('M');
            $K = $key->tarif * 100;
            $L = floor($key->ppn * ($key->tarif));
            $M = $key->ppn;
            $N = $key->ppn;
            $spreadsheet->getActiveSheet()->setCellValue('A' . $row, $no++)
                ->setCellValue('B' . $row, $B)
                ->setCellValue('C' . $row, $C)
                ->setCellValue('D' . $row, $D)
                ->setCellValue('E' . $row, $E)
                ->setCellValue('F' . $row, $F)
                ->setCellValue('G' . $row, $G)
                ->setCellValue('H' . $row, $H)
                ->setCellValue('I' . $row, $I)
                ->setCellValue('J' . $row, $J)
                ->setCellValue('K' . $row, $K . '%')
                ->setCellValue('L' . $row, $L)
                ->setCellValue('M' . $row, $M)
                ->setCellValue('N' . $row, $N);
                $spreadsheet->getActiveSheet()->getCell('D' . $row)->setValueExplicit($D, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $spreadsheet->getActiveSheet()->getCell('F' . $row)->setValueExplicit($F, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $spreadsheet->getActiveSheet()->getCell('H' . $row)->setValueExplicit($H, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                if ($E) {
                    $spreadsheet->getActiveSheet()->getCell('E' . $row)->setValueExplicit($E, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_ISO_DATE);
                }
                $spreadsheet->getActiveSheet()->getCell('I' . $row)->setValueExplicit($I, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_ISO_DATE);
            $row++;
        }
        $spreadsheet->setActiveSheetIndex(0)->getStyle('A:N')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
        $spreadsheet->setActiveSheetIndex(0)->getStyle('E:E')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
        $spreadsheet->setActiveSheetIndex(0)->getStyle('I:I')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_DATE_DDMMYYYY);
        $spreadsheet->setActiveSheetIndex(0)->getStyle('K:K')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_PERCENTAGE_00);
        $spreadsheet->setActiveSheetIndex(0)->getStyle('L:N')->getNumberFormat()->setFormatCode('Rp* #,##0.00');
        $spreadsheet->setActiveSheetIndex(0)->getStyle('A1:N1')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
        $spreadsheet->getActiveSheet()
        ->getStyle('A1:N1')
        ->applyFromArray($textcenter);
        $spreadsheet->getActiveSheet()
        ->getStyle('A1:N'.$row)
        ->applyFromArray($styleBorder);
        foreach ($spreadsheet->setActiveSheetIndex(0)->getColumnIterator() as $column) {
            $spreadsheet->setActiveSheetIndex(0)->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="PPN - ' . date('D, d M Y H:i:s') . '.xlsx"');
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
