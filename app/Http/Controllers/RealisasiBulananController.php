<?php

namespace App\Http\Controllers;

use App\Models\pagu;
use App\Models\unit;
use App\Models\bulan;
use App\Helper\Notification;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class RealisasiBulananController extends Controller
{
    public function index($bulan = null)
    {
        if ($bulan == null) {
            $bulanModel = bulan::where('kodebulan', date('m'))->first();
        } else {
            $bulanModel = bulan::where('kodebulan', $bulan)->first();
        }
        return view('data_cleansing.realisasi_bulanan.index', [
            'data' => pagu::paguSatker()->RealisasiBulanan($bulanModel->kodebulan),
            'bulan' => $bulanModel,
            'notifikasi' => Notification::Notif(),
        ]);
    }

    public function download($bulan = null)
    {
        if ($bulan == null) {
            $bulanModel = bulan::where('kodebulan', date('m'))->first();
        } else {
            $bulanModel = bulan::where('kodebulan', $bulan)->first();
        }
        $data = pagu::paguSatker()->RealisasiBulanan($bulanModel->kodebulan);

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
        $realisasiProgram = $spreadsheet->getActiveSheet(0);
        $realisasiProgram->setTitle('Realisasi Anggaran');
        $spreadsheet
            ->setActiveSheetIndexByName('Realisasi Anggaran')
            ->setCellValue('A3', 'Realisasi Anggaran')
            ->mergeCells('A3:L3')
            ->setCellValue('A4', $bulanModel->namabulan . ' ' . session()->get('tahun'))
            ->mergeCells('A4:L4');
        $spreadsheet->getActiveSheet()
            ->getStyle('A3:B4')
            ->applyFromArray($textcenter);
        $spreadsheet->getActiveSheet()
            ->getStyle('A6:M6')
            ->applyFromArray($textcenter);
        $spreadsheet->getActiveSheet()
            ->setCellValue('A6', 'POK')
            ->setCellValue('B6', 'Program')
            ->setCellValue('C6', 'Kegiatan')
            ->setCellValue('D6', 'KRO')
            ->setCellValue('E6', 'RO')
            ->setCellValue('F6', 'Komponen')
            ->setCellValue('G6', 'Sub Komponen')
            ->setCellValue('H6', 'Akun')
            ->setCellValue('J6', 'Realisasi')
            ->setCellValue('K6', 'Pengembalian')
            ->setCellValue('L6', 'Unit')
            ->setCellValue('M6', '-');
        $programs = $data->groupBy('program');
        $row = 7;
        foreach ($programs as $program) {
            $realisasiProgram = 0;
            $pengembalianProgram = 0 ;
            foreach($program as $p){
                $realisasiProgram += $p->realisasi->sum('realisasi');
                $pengembalianProgram += $p->sspb->sum('nominal_sspb');
            }
            $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($program->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
            $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($program->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
            $spreadsheet->getActiveSheet()->getCell('M' . $row)->setValueExplicit('Program', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
            $spreadsheet->getActiveSheet()->setCellValue('J' . $row, $realisasiProgram);
            $spreadsheet->getActiveSheet()->setCellValue('K' . $row, $pengembalianProgram);
            $row++;
            $kegiatans = $program->groupBy('kegiatan');
            foreach ($kegiatans as $kegiatan) {
                $realisasiKegiatan = 0;
                $pengembalianKegiatan = 0 ;
                foreach($kegiatan as $k){
                    $realisasiKegiatan += $k->realisasi->sum('realisasi');
                    $pengembalianKegiatan += $k->sspb->sum('nominal_sspb');
                }
                $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($kegiatan->first()->program . "." . $kegiatan->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($kegiatan->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($kegiatan->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $spreadsheet->getActiveSheet()->getCell('M' . $row)->setValueExplicit('Kegiatan', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $spreadsheet->getActiveSheet()->setCellValue('J' . $row, $realisasiKegiatan);
                $spreadsheet->getActiveSheet()->setCellValue('K' . $row, $pengembalianKegiatan);
                $row++;
                $kros = $kegiatan->groupBy('kro');
                foreach ($kros as $kro) {
                    $realisasiKro = 0;
                    $pengembalianKro = 0 ;
                    foreach($kro as $kr){
                        $realisasiKro += $kr->realisasi->sum('realisasi');
                        $pengembalianKro += $kr->sspb->sum('nominal_sspb');
                    }
                    $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($kro->first()->program . "." . $kro->first()->kegiatan . "." . $kro->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                    $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($kro->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                    $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($kro->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                    $spreadsheet->getActiveSheet()->getCell('D' . $row)->setValueExplicit($kro->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                    $spreadsheet->getActiveSheet()->getCell('M' . $row)->setValueExplicit('KRO', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                    $spreadsheet->getActiveSheet()->setCellValue('J' . $row, $realisasiKro);
                    $spreadsheet->getActiveSheet()->setCellValue('K' . $row, $pengembalianKro);
                    $row++;
                    $ros = $kro->groupBy('ro');
                    foreach ($ros as $ro) {
                        $realisasiRo = 0;
                        $pengembalianRo = 0 ;
                        foreach($ro as $r){
                            $realisasiRo += $r->realisasi->sum('realisasi');
                            $pengembalianRo += $r->sspb->sum('nominal_sspb');
                        }
                        $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($ro->first()->program . "." . $ro->first()->kegiatan . "." . $ro->first()->kro . "." . $ro->first()->ro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                        $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($ro->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                        $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($ro->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                        $spreadsheet->getActiveSheet()->getCell('D' . $row)->setValueExplicit($ro->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                        $spreadsheet->getActiveSheet()->getCell('E' . $row)->setValueExplicit($ro->first()->ro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                        $spreadsheet->getActiveSheet()->getCell('M' . $row)->setValueExplicit('RO', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                        $spreadsheet->getActiveSheet()->setCellValue('J' . $row, $realisasiRo);
                        $spreadsheet->getActiveSheet()->setCellValue('K' . $row, $pengembalianRo);
                        $row++;
                        $komponens = $ro->groupBy('komponen');
                        foreach ($komponens as $komponen) {
                            $realisasiKomponen = 0;
                            $pengembalianKomponen = 0 ;
                            foreach($komponen as $kom){
                                $realisasiKomponen += $kom->realisasi->sum('realisasi');
                                $pengembalianKomponen += $kom->sspb->sum('nominal_sspb');
                            }
                            $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($komponen->first()->program . "." . $komponen->first()->kegiatan . "." . $komponen->first()->kro . "." . $komponen->first()->ro . "." . $komponen->first()->komponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($komponen->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($komponen->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->getCell('D' . $row)->setValueExplicit($komponen->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->getCell('E' . $row)->setValueExplicit($komponen->first()->ro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->getCell('F' . $row)->setValueExplicit($komponen->first()->komponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->getCell('M' . $row)->setValueExplicit('Komponen', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->setCellValue('J' . $row, $realisasiKomponen);
                            $spreadsheet->getActiveSheet()->setCellValue('K' . $row, $pengembalianKomponen);
                            $row++;
                            $subKomponens = $komponen->groupBy('subkomponen');
                            foreach ($subKomponens as $subKomponen) {
                                $realisasiSubKomponen = 0;
                                $pengembalianSubKomponen = 0;
                                foreach($subKomponen as $sk){
                                    $realisasiSubKomponen += $sk->realisasi->sum('realisasi');
                                    $pengembalianSubKomponen += $sk->sspb->sum('nominal_sspb');
                                }
                                $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($subKomponen->first()->program . "." . $subKomponen->first()->kegiatan . "." . $subKomponen->first()->kro . "." . $subKomponen->first()->ro . "." . $subKomponen->first()->komponen . "." . $subKomponen->first()->subkomponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($subKomponen->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($subKomponen->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('D' . $row)->setValueExplicit($subKomponen->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('E' . $row)->setValueExplicit($subKomponen->first()->ro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('F' . $row)->setValueExplicit($subKomponen->first()->komponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('G' . $row)->setValueExplicit($subKomponen->first()->subkomponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('M' . $row)->setValueExplicit('Sub Komponen', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->setCellValue('J' . $row, $realisasiSubKomponen);
                                $spreadsheet->getActiveSheet()->setCellValue('K' . $row, $pengembalianSubKomponen);
                                $row++;
                                $akuns = $subKomponen->groupBy('akun');
                                foreach ($akuns as $akun) {
                                    $realisasiAkun = 0;
                                    $pengembalianAkun = 0;
                                    foreach($akun as $ak){
                                        $realisasiAkun += $ak->realisasi->sum('realisasi');
                                        $pengembalianAkun += $ak->sspb->sum('nominal_sspb');
                                    }
                                    $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($akun->first()->program . "." . $akun->first()->kegiatan . "." . $akun->first()->kro . "." . $akun->first()->ro . "." . $akun->first()->komponen . "." . $akun->first()->subkomponen . "." . $akun->first()->akun, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($akun->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($akun->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('D' . $row)->setValueExplicit($akun->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('E' . $row)->setValueExplicit($akun->first()->ro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('F' . $row)->setValueExplicit($akun->first()->komponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('G' . $row)->setValueExplicit($akun->first()->subkomponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('H' . $row)->setValueExplicit($akun->first()->akun, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('M' . $row)->setValueExplicit('Akun', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->setCellValue('J' . $row, $realisasiAkun);
                                    $spreadsheet->getActiveSheet()->setCellValue('K' . $row, $pengembalianAkun);
                                    $spreadsheet->getActiveSheet()->setCellValue('L' . $row, optional($akun->first()->unit)->namaunit);
                                    $row++;
                                }
                            }
                        }
                    }
                }
            }
        }
        $spreadsheet->setActiveSheetIndex(0)->getStyle('I7:K' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
        $spreadsheet->setActiveSheetIndex(0)->getStyle('A6:M' . $row)->applyFromArray($styleBorder);

        foreach ($spreadsheet->setActiveSheetIndex(0)->getColumnIterator() as $column) {
            $spreadsheet->setActiveSheetIndex(0)->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        foreach(unit::myunit()->whereHas('pagu')->get() as $unit) {
            $dataSheet = $spreadsheet->createSheet();
            if(strlen($unit->namaunit) > 31) {
                $a = explode(" ",$unit->namaunit);
                $name= "";
                foreach($a as $b){
                    if(ctype_upper(substr($b,0,1))){
                        $name .= substr($b,0,1);
                    };
                }
                $dataSheet->setTitle($name);
            }else{
                $dataSheet->setTitle($unit->namaunit);
                $name = $unit->namaunit;
            }
            $spreadsheet->setActiveSheetIndexByName($name);
            $data = pagu::paguSatker()->PaguUnit($unit->kodeunit)->RealisasiBulanan($bulanModel->kodebulan);

            $spreadsheet
                ->setActiveSheetIndexByName($name)
                ->setCellValue('A3', $unit->namaunit)
                ->mergeCells('A3:L3')
                ->setCellValue('A4', $bulanModel->namabulan . ' ' . session()->get('tahun'))
                ->mergeCells('A4:L4');
            $spreadsheet->getActiveSheet()
                ->getStyle('A3:B4')
                ->applyFromArray($textcenter);
            $spreadsheet->getActiveSheet()
                ->getStyle('A6:L6')
                ->applyFromArray($textcenter);
            $spreadsheet->getActiveSheet()
                ->setCellValue('A6', 'POK')
                ->setCellValue('B6', 'Program')
                ->setCellValue('C6', 'Kegiatan')
                ->setCellValue('D6', 'KRO')
                ->setCellValue('E6', 'RO')
                ->setCellValue('F6', 'Komponen')
                ->setCellValue('G6', 'Sub Komponen')
                ->setCellValue('H6', 'Akun')
                ->setCellValue('J6', 'Realisasi')
                ->setCellValue('K6', 'Pengembalian')
                ->setCellValue('L6', '-');
            $programs = $data->groupBy('program');
            $row = 7;
            foreach ($programs as $program) {
                $realisasiProgram = 0;
                $pengembalianProgram = 0 ;
                foreach($program as $p){
                    $realisasiProgram += $p->realisasi->sum('realisasi');
                    $pengembalianProgram += $p->sspb->sum('nominal_sspb');
                }
                $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($program->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($program->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $spreadsheet->getActiveSheet()->getCell('L' . $row)->setValueExplicit('Program', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $spreadsheet->getActiveSheet()->setCellValue('J' . $row, $realisasiProgram);
                $spreadsheet->getActiveSheet()->setCellValue('K' . $row, $pengembalianProgram);
                $row++;
                $kegiatans = $program->groupBy('kegiatan');
                foreach ($kegiatans as $kegiatan) {
                    $realisasiKegiatan = 0;
                    $pengembalianKegiatan = 0 ;
                    foreach($kegiatan as $k){
                        $realisasiKegiatan += $k->realisasi->sum('realisasi');
                        $pengembalianKegiatan += $k->sspb->sum('nominal_sspb');
                    }
                    $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($kegiatan->first()->program . "." . $kegiatan->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                    $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($kegiatan->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                    $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($kegiatan->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                    $spreadsheet->getActiveSheet()->getCell('L' . $row)->setValueExplicit('Kegiatan', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                    $spreadsheet->getActiveSheet()->setCellValue('J' . $row, $realisasiKegiatan);
                    $spreadsheet->getActiveSheet()->setCellValue('K' . $row, $pengembalianKegiatan);
                    $row++;
                    $kros = $kegiatan->groupBy('kro');
                    foreach ($kros as $kro) {
                        $realisasiKro = 0;
                        $pengembalianKro = 0 ;
                        foreach($kro as $kr){
                            $realisasiKro += $kr->realisasi->sum('realisasi');
                            $pengembalianKro += $kr->sspb->sum('nominal_sspb');
                        }
                        $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($kro->first()->program . "." . $kro->first()->kegiatan . "." . $kro->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                        $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($kro->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                        $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($kro->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                        $spreadsheet->getActiveSheet()->getCell('D' . $row)->setValueExplicit($kro->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                        $spreadsheet->getActiveSheet()->getCell('L' . $row)->setValueExplicit('KRO', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                        $spreadsheet->getActiveSheet()->setCellValue('J' . $row, $realisasiKro);
                        $spreadsheet->getActiveSheet()->setCellValue('K' . $row, $pengembalianKro);
                        $row++;
                        $ros = $kro->groupBy('ro');
                        foreach ($ros as $ro) {
                            $realisasiRo = 0;
                            $pengembalianRo = 0 ;
                            foreach($ro as $r){
                                $realisasiRo += $r->realisasi->sum('realisasi');
                                $pengembalianRo += $r->sspb->sum('nominal_sspb');
                            }
                            $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($ro->first()->program . "." . $ro->first()->kegiatan . "." . $ro->first()->kro . "." . $ro->first()->ro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($ro->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($ro->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->getCell('D' . $row)->setValueExplicit($ro->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->getCell('E' . $row)->setValueExplicit($ro->first()->ro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->getCell('L' . $row)->setValueExplicit('RO', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->setCellValue('J' . $row, $realisasiRo);
                            $spreadsheet->getActiveSheet()->setCellValue('K' . $row, $pengembalianRo);
                            $row++;
                            $komponens = $ro->groupBy('komponen');
                            foreach ($komponens as $komponen) {
                                $realisasiKomponen = 0;
                                $pengembalianKomponen = 0 ;
                                foreach($komponen as $kom){
                                    $realisasiKomponen += $kom->realisasi->sum('realisasi');
                                    $pengembalianKomponen += $kom->sspb->sum('nominal_sspb');
                                }
                                $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($komponen->first()->program . "." . $komponen->first()->kegiatan . "." . $komponen->first()->kro . "." . $komponen->first()->ro . "." . $komponen->first()->komponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($komponen->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($komponen->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('D' . $row)->setValueExplicit($komponen->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('E' . $row)->setValueExplicit($komponen->first()->ro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('F' . $row)->setValueExplicit($komponen->first()->komponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('L' . $row)->setValueExplicit('Komponen', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->setCellValue('J' . $row, $realisasiKomponen);
                                $spreadsheet->getActiveSheet()->setCellValue('K' . $row, $pengembalianKomponen);
                                $row++;
                                $subKomponens = $komponen->groupBy('subkomponen');
                                foreach ($subKomponens as $subKomponen) {
                                    $realisasiSubKomponen = 0;
                                    $pengembalianSubKomponen = 0;
                                    foreach($subKomponen as $sk){
                                        $realisasiSubKomponen += $sk->realisasi->sum('realisasi');
                                        $pengembalianSubKomponen += $sk->sspb->sum('nominal_sspb');
                                    }
                                    $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($subKomponen->first()->program . "." . $subKomponen->first()->kegiatan . "." . $subKomponen->first()->kro . "." . $subKomponen->first()->ro . "." . $subKomponen->first()->komponen . "." . $subKomponen->first()->subkomponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($subKomponen->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($subKomponen->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('D' . $row)->setValueExplicit($subKomponen->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('E' . $row)->setValueExplicit($subKomponen->first()->ro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('F' . $row)->setValueExplicit($subKomponen->first()->komponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('G' . $row)->setValueExplicit($subKomponen->first()->subkomponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('L' . $row)->setValueExplicit('Sub Komponen', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->setCellValue('J' . $row, $realisasiSubKomponen);
                                    $spreadsheet->getActiveSheet()->setCellValue('K' . $row, $pengembalianSubKomponen);
                                    $row++;
                                    $akuns = $subKomponen->groupBy('akun');
                                    foreach ($akuns as $akun) {
                                        $realisasiAkun = 0;
                                        $pengembalianAkun = 0;
                                        foreach($akun as $ak){
                                            $realisasiAkun += $ak->realisasi->sum('realisasi');
                                            $pengembalianAkun += $ak->sspb->sum('nominal_sspb');
                                        }
                                        $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($akun->first()->program . "." . $akun->first()->kegiatan . "." . $akun->first()->kro . "." . $akun->first()->ro . "." . $akun->first()->komponen . "." . $akun->first()->subkomponen . "." . $akun->first()->akun, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                        $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($akun->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                        $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($akun->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                        $spreadsheet->getActiveSheet()->getCell('D' . $row)->setValueExplicit($akun->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                        $spreadsheet->getActiveSheet()->getCell('E' . $row)->setValueExplicit($akun->first()->ro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                        $spreadsheet->getActiveSheet()->getCell('F' . $row)->setValueExplicit($akun->first()->komponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                        $spreadsheet->getActiveSheet()->getCell('G' . $row)->setValueExplicit($akun->first()->subkomponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                        $spreadsheet->getActiveSheet()->getCell('H' . $row)->setValueExplicit($akun->first()->akun, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                        $spreadsheet->getActiveSheet()->getCell('L' . $row)->setValueExplicit('Akun', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                        $spreadsheet->getActiveSheet()->setCellValue('J' . $row, $realisasiAkun);
                                        $spreadsheet->getActiveSheet()->setCellValue('K' . $row, $pengembalianAkun);
                                        $row++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $spreadsheet->setActiveSheetIndexByName($name)->getStyle('I7:K' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
            $spreadsheet->setActiveSheetIndexByName($name)->getStyle('A6:L' . $row)->applyFromArray($styleBorder);
    
            foreach ($spreadsheet->setActiveSheetIndexByName($name)->getColumnIterator() as $column) {
                $spreadsheet->setActiveSheetIndexByName($name)->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
            }
        }
        $spreadsheet->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Realisasi - ' . date('D, d M Y H:i:s') . '.xlsx"');
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

    public function downloadWithSum($bulan = null)
    {
        if ($bulan == null) {
            $bulanModel = bulan::where('kodebulan', date('m'))->first();
        } else {
            $bulanModel = bulan::where('kodebulan', $bulan)->first();
        }
        $data = pagu::paguSatker()->RealisasiBulananWithSum($bulanModel->kodebulan);

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
        $realisasiProgram = $spreadsheet->getActiveSheet(0);
        $realisasiProgram->setTitle('Realisasi Anggaran');
        $spreadsheet
            ->setActiveSheetIndexByName('Realisasi Anggaran')
            ->setCellValue('A3', 'Realisasi Anggaran')
            ->mergeCells('A3:L3')
            ->setCellValue('A4', 'Sampai Dengan ' . $bulanModel->namabulan . ' ' . session()->get('tahun'))
            ->mergeCells('A4:L4');
        $spreadsheet->getActiveSheet()
            ->getStyle('A3:B4')
            ->applyFromArray($textcenter);
        $spreadsheet->getActiveSheet()
            ->getStyle('A6:M6')
            ->applyFromArray($textcenter);
        $spreadsheet->getActiveSheet()
            ->setCellValue('A6', 'POK')
            ->setCellValue('B6', 'Program')
            ->setCellValue('C6', 'Kegiatan')
            ->setCellValue('D6', 'KRO')
            ->setCellValue('E6', 'RO')
            ->setCellValue('F6', 'Komponen')
            ->setCellValue('G6', 'Sub Komponen')
            ->setCellValue('H6', 'Akun')
            ->setCellValue('I6', 'Anggaran')
            ->setCellValue('J6', 'Realisasi')
            ->setCellValue('K6', 'Pengembalian')
            ->setCellValue('L6', 'Unit')
            ->setCellValue('M6', '-');
        $programs = $data->groupBy('program');
        $row = 7;
        foreach ($programs as $program) {
            $realisasiProgram = 0;
            $pengembalianProgram = 0 ;
            foreach($program as $p){
                $realisasiProgram += $p->realisasi->sum('realisasi');
                $pengembalianProgram += $p->sspb->sum('nominal_sspb');
            }
            $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($program->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
            $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($program->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
            $spreadsheet->getActiveSheet()->getCell('M' . $row)->setValueExplicit('Program', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
            $spreadsheet->getActiveSheet()->setCellValue('J' . $row, $realisasiProgram)->setCellValue('K' . $row, $pengembalianProgram)->setCellValue('I' . $row, $program->sum('anggaran'));
            $row++;
            $kegiatans = $program->groupBy('kegiatan');
            foreach ($kegiatans as $kegiatan) {
                $realisasiKegiatan = 0;
                $pengembalianKegiatan = 0 ;
                foreach($kegiatan as $k){
                    $realisasiKegiatan += $k->realisasi->sum('realisasi');
                    $pengembalianKegiatan += $k->sspb->sum('nominal_sspb');
                }
                $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($kegiatan->first()->program . '.' . $kegiatan->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($kegiatan->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($kegiatan->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $spreadsheet->getActiveSheet()->getCell('M' . $row)->setValueExplicit('Kegiatan', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $spreadsheet->getActiveSheet()
                    ->setCellValue('I' . $row, $kegiatan->sum('anggaran'))
                    ->setCellValue('J' . $row, $realisasiKegiatan)
                    ->setCellValue('K' . $row, $pengembalianKegiatan);
                $row++;
                $kros = $kegiatan->groupBy('kro');
                foreach ($kros as $kro) {
                    $realisasiKro = 0;
                    $pengembalianKro = 0 ;
                    foreach($kro as $kr){
                        $realisasiKro += $kr->realisasi->sum('realisasi');
                        $pengembalianKro += $kr->sspb->sum('nominal_sspb');
                    }
                    $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($kro->first()->program . '.' . $kro->first()->kegiatan . '.' . $kro->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                    $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($kro->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                    $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($kro->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                    $spreadsheet->getActiveSheet()->getCell('D' . $row)->setValueExplicit($kro->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                    $spreadsheet->getActiveSheet()->getCell('M' . $row)->setValueExplicit('KRO', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                    $spreadsheet->getActiveSheet()
                        ->setCellValue('I' . $row, $kro->sum('anggaran'))
                        ->setCellValue('J' . $row, $realisasiKro)
                        ->setCellValue('K' . $row, $pengembalianKro);
                    $row++;
                    $ros = $kro->groupBy('ro');
                    foreach ($ros as $ro) {
                        $realisasiRo = 0;
                        $pengembalianRo = 0 ;
                        foreach($ro as $r){
                            $realisasiRo += $r->realisasi->sum('realisasi');
                            $pengembalianRo += $r->sspb->sum('nominal_sspb');
                        }
                        $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($ro->first()->program . '.' . $ro->first()->kegiatan . '.' . $ro->first()->kro . '.' . $ro->first()->ro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                        $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($ro->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                        $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($ro->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                        $spreadsheet->getActiveSheet()->getCell('D' . $row)->setValueExplicit($ro->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                        $spreadsheet->getActiveSheet()->getCell('E' . $row)->setValueExplicit($ro->first()->ro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                        $spreadsheet->getActiveSheet()->getCell('M' . $row)->setValueExplicit('RO', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                        $spreadsheet->getActiveSheet()
                            ->setCellValue('I' . $row, $ro->sum('anggaran'))
                            ->setCellValue('J' . $row, $realisasiRo)
                            ->setCellValue('K' . $row, $pengembalianRo);
                        $row++;
                        $komponens = $ro->groupBy('komponen');
                        foreach ($komponens as $komponen) {
                            $realisasiKomponen = 0;
                            $pengembalianKomponen = 0 ;
                            foreach($komponen as $kom){
                                $realisasiKomponen += $kom->realisasi->sum('realisasi');
                                $pengembalianKomponen += $kom->sspb->sum('nominal_sspb');
                            }
                            $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($komponen->first()->program . '.' . $komponen->first()->kegiatan . '.' . $komponen->first()->kro . '.' . $komponen->first()->ro . '.' . $komponen->first()->komponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($komponen->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($komponen->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->getCell('D' . $row)->setValueExplicit($komponen->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->getCell('E' . $row)->setValueExplicit($komponen->first()->ro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->getCell('F' . $row)->setValueExplicit($komponen->first()->komponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->getCell('M' . $row)->setValueExplicit('Komponen', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()
                                ->setCellValue('I' . $row, $komponen->sum('anggaran'))
                                ->setCellValue('J' . $row, $realisasiKomponen)
                                ->setCellValue('K' . $row, $pengembalianKomponen);
                            $row++;
                            $subKomponens = $komponen->groupBy('subkomponen');
                            foreach ($subKomponens as $subKomponen) {
                                $realisasiSubKomponen = 0;
                                $pengembalianSubKomponen = 0;
                                foreach($subKomponen as $sk){
                                    $realisasiSubKomponen += $sk->realisasi->sum('realisasi');
                                    $pengembalianSubKomponen += $sk->sspb->sum('nominal_sspb');
                                }
                                $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($subKomponen->first()->program . '.' . $subKomponen->first()->kegiatan . '.' . $subKomponen->first()->kro . '.' . $subKomponen->first()->ro . '.' . $subKomponen->first()->komponen . '.' . $subKomponen->first()->subkomponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($subKomponen->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($subKomponen->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('D' . $row)->setValueExplicit($subKomponen->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('E' . $row)->setValueExplicit($subKomponen->first()->ro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('F' . $row)->setValueExplicit($subKomponen->first()->komponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('G' . $row)->setValueExplicit($subKomponen->first()->subkomponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('M' . $row)->setValueExplicit('Sub Komponen', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()
                                    ->setCellValue('I' . $row, $subKomponen->sum('anggaran'))
                                    ->setCellValue('J' . $row, $realisasiSubKomponen)
                                    ->setCellValue('K' . $row, $pengembalianSubKomponen);
                                $row++;
                                $akuns = $subKomponen->groupBy('akun');
                                foreach ($akuns as $akun) {
                                    $realisasiAkun = 0;
                                    $pengembalianAkun = 0;
                                    foreach($akun as $ak){
                                        $realisasiAkun += $ak->realisasi->sum('realisasi');
                                        $pengembalianAkun += $ak->sspb->sum('nominal_sspb');
                                    }
                                    $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($akun->first()->program . '.' . $akun->first()->kegiatan . '.' . $akun->first()->kro . '.' . $akun->first()->ro . '.' . $akun->first()->komponen . '.' . $akun->first()->subkomponen . '.' . $akun->first()->akun, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($akun->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($akun->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('D' . $row)->setValueExplicit($akun->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('E' . $row)->setValueExplicit($akun->first()->ro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('F' . $row)->setValueExplicit($akun->first()->komponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('G' . $row)->setValueExplicit($akun->first()->subkomponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('H' . $row)->setValueExplicit($akun->first()->akun, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('M' . $row)->setValueExplicit('Akun', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()
                                        ->setCellValue('I' . $row, $akun->sum('anggaran'))
                                        ->setCellValue('J' . $row, $realisasiAkun)
                                        ->setCellValue('K' . $row, $pengembalianAkun)
                                        ->setCellValue('L' . $row, optional($akun->first()->unit)->namaunit);
                                    $row++;
                                }
                            }
                        }
                    }
                }
            }
        }
        $spreadsheet->setActiveSheetIndex(0)->getStyle('I7:K' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
        $spreadsheet->setActiveSheetIndex(0)->getStyle('A6:M' . $row)->applyFromArray($styleBorder);

        foreach ($spreadsheet->setActiveSheetIndex(0)->getColumnIterator() as $column) {
            $spreadsheet->setActiveSheetIndex(0)->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        foreach(unit::myunit()->whereHas('pagu')->get() as $unit) {
            $dataSheet = $spreadsheet->createSheet();
            if(strlen($unit->namaunit) > 31) {
                $a = explode(" ",$unit->namaunit);
                $name= "";
                foreach($a as $b){
                    if(ctype_upper(substr($b,0,1))){
                        $name .= substr($b,0,1);
                    };
                }
                $dataSheet->setTitle($name);
            }else{
                $dataSheet->setTitle($unit->namaunit);
                $name = $unit->namaunit;
            }
            $spreadsheet->setActiveSheetIndexByName($name);
            $data = pagu::paguSatker()->PaguUnit($unit->kodeunit)->RealisasiBulananWithSum($bulanModel->kodebulan);
            
            $spreadsheet
            ->setActiveSheetIndexByName($name)
            ->setCellValue('A3', $unit->namaunit)
            ->mergeCells('A3:L3')
            ->setCellValue('A4', 'Sampai Dengan ' . $bulanModel->namabulan . ' ' . session()->get('tahun'))
            ->mergeCells('A4:L4');
            $spreadsheet->getActiveSheet()
                ->getStyle('A3:B4')
                ->applyFromArray($textcenter);
            $spreadsheet->getActiveSheet()
                ->getStyle('A6:L6')
                ->applyFromArray($textcenter);
            $spreadsheet->getActiveSheet()
                ->setCellValue('A6', 'POK')
                ->setCellValue('B6', 'Program')
                ->setCellValue('C6', 'Kegiatan')
                ->setCellValue('D6', 'KRO')
                ->setCellValue('E6', 'RO')
                ->setCellValue('F6', 'Komponen')
                ->setCellValue('G6', 'Sub Komponen')
                ->setCellValue('H6', 'Akun')
                ->setCellValue('I6', 'Anggaran')
                ->setCellValue('J6', 'Realisasi')
                ->setCellValue('K6', 'Pengembalian')
                ->setCellValue('L6', '-');
            $programs = $data->groupBy('program');
            $row = 7;
            foreach ($programs as $program) {
                $realisasiProgram = 0;
                $pengembalianProgram = 0 ;
                foreach($program as $p){
                    $realisasiProgram += $p->realisasi->sum('realisasi');
                    $pengembalianProgram += $p->sspb->sum('nominal_sspb');
                }
                $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($program->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($program->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $spreadsheet->getActiveSheet()->getCell('L' . $row)->setValueExplicit('Program', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $spreadsheet->getActiveSheet()->setCellValue('J' . $row, $realisasiProgram)->setCellValue('K' . $row, $pengembalianProgram)->setCellValue('I' . $row, $program->sum('anggaran'));
                $row++;
                $kegiatans = $program->groupBy('kegiatan');
                foreach ($kegiatans as $kegiatan) {
                    $realisasiKegiatan = 0;
                    $pengembalianKegiatan = 0 ;
                    foreach($kegiatan as $k){
                        $realisasiKegiatan += $k->realisasi->sum('realisasi');
                        $pengembalianKegiatan += $k->sspb->sum('nominal_sspb');
                    }
                    $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($kegiatan->first()->program . '.' . $kegiatan->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                    $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($kegiatan->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                    $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($kegiatan->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                    $spreadsheet->getActiveSheet()->getCell('L' . $row)->setValueExplicit('Kegiatan', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                    $spreadsheet->getActiveSheet()
                        ->setCellValue('I' . $row, $kegiatan->sum('anggaran'))
                        ->setCellValue('J' . $row, $realisasiKegiatan)
                        ->setCellValue('K' . $row, $pengembalianKegiatan);
                    $row++;
                    $kros = $kegiatan->groupBy('kro');
                    foreach ($kros as $kro) {
                        $realisasiKro = 0;
                        $pengembalianKro = 0 ;
                        foreach($kro as $kr){
                            $realisasiKro += $kr->realisasi->sum('realisasi');
                            $pengembalianKro += $kr->sspb->sum('nominal_sspb');
                        }
                        $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($kro->first()->program . '.' . $kro->first()->kegiatan . '.' . $kro->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                        $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($kro->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                        $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($kro->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                        $spreadsheet->getActiveSheet()->getCell('D' . $row)->setValueExplicit($kro->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                        $spreadsheet->getActiveSheet()->getCell('L' . $row)->setValueExplicit('KRO', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                        $spreadsheet->getActiveSheet()
                            ->setCellValue('I' . $row, $kro->sum('anggaran'))
                            ->setCellValue('J' . $row, $realisasiKro)
                            ->setCellValue('K' . $row, $pengembalianKro);
                        $row++;
                        $ros = $kro->groupBy('ro');
                        foreach ($ros as $ro) {
                            $realisasiRo = 0;
                            $pengembalianRo = 0 ;
                            foreach($ro as $r){
                                $realisasiRo += $r->realisasi->sum('realisasi');
                                $pengembalianRo += $r->sspb->sum('nominal_sspb');
                            }
                            $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($ro->first()->program . '.' . $ro->first()->kegiatan . '.' . $ro->first()->kro . '.' . $ro->first()->ro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($ro->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($ro->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->getCell('D' . $row)->setValueExplicit($ro->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->getCell('E' . $row)->setValueExplicit($ro->first()->ro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()->getCell('L' . $row)->setValueExplicit('RO', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                            $spreadsheet->getActiveSheet()
                                ->setCellValue('I' . $row, $ro->sum('anggaran'))
                                ->setCellValue('J' . $row, $realisasiRo)
                                ->setCellValue('K' . $row, $pengembalianRo);
                            $row++;
                            $komponens = $ro->groupBy('komponen');
                            foreach ($komponens as $komponen) {
                                $realisasiKomponen = 0;
                                $pengembalianKomponen = 0 ;
                                foreach($komponen as $kom){
                                    $realisasiKomponen += $kom->realisasi->sum('realisasi');
                                    $pengembalianKomponen += $kom->sspb->sum('nominal_sspb');
                                }
                                $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($komponen->first()->program . '.' . $komponen->first()->kegiatan . '.' . $komponen->first()->kro . '.' . $komponen->first()->ro . '.' . $komponen->first()->komponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($komponen->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($komponen->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('D' . $row)->setValueExplicit($komponen->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('E' . $row)->setValueExplicit($komponen->first()->ro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('F' . $row)->setValueExplicit($komponen->first()->komponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()->getCell('L' . $row)->setValueExplicit('Komponen', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                $spreadsheet->getActiveSheet()
                                    ->setCellValue('I' . $row, $komponen->sum('anggaran'))
                                    ->setCellValue('J' . $row, $realisasiKomponen)
                                    ->setCellValue('K' . $row, $pengembalianKomponen);
                                $row++;
                                $subKomponens = $komponen->groupBy('subkomponen');
                                foreach ($subKomponens as $subKomponen) {
                                    $realisasiSubKomponen = 0;
                                    $pengembalianSubKomponen = 0;
                                    foreach($subKomponen as $sk){
                                        $realisasiSubKomponen += $sk->realisasi->sum('realisasi');
                                        $pengembalianSubKomponen += $sk->sspb->sum('nominal_sspb');
                                    }
                                    $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($subKomponen->first()->program . '.' . $subKomponen->first()->kegiatan . '.' . $subKomponen->first()->kro . '.' . $subKomponen->first()->ro . '.' . $subKomponen->first()->komponen . '.' . $subKomponen->first()->subkomponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($subKomponen->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($subKomponen->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('D' . $row)->setValueExplicit($subKomponen->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('E' . $row)->setValueExplicit($subKomponen->first()->ro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('F' . $row)->setValueExplicit($subKomponen->first()->komponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('G' . $row)->setValueExplicit($subKomponen->first()->subkomponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()->getCell('L' . $row)->setValueExplicit('Sub Komponen', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                    $spreadsheet->getActiveSheet()
                                        ->setCellValue('I' . $row, $subKomponen->sum('anggaran'))
                                        ->setCellValue('J' . $row, $realisasiSubKomponen)
                                        ->setCellValue('K' . $row, $pengembalianSubKomponen);
                                    $row++;
                                    $akuns = $subKomponen->groupBy('akun');
                                    foreach ($akuns as $akun) {
                                        $realisasiAkun = 0;
                                        $pengembalianAkun = 0;
                                        foreach($akun as $ak){
                                            $realisasiAkun += $ak->realisasi->sum('realisasi');
                                            $pengembalianAkun += $ak->sspb->sum('nominal_sspb');
                                        }
                                        $spreadsheet->getActiveSheet()->getCell('A' . $row)->setValueExplicit($akun->first()->program . '.' . $akun->first()->kegiatan . '.' . $akun->first()->kro . '.' . $akun->first()->ro . '.' . $akun->first()->komponen . '.' . $akun->first()->subkomponen . '.' . $akun->first()->akun, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                        $spreadsheet->getActiveSheet()->getCell('B' . $row)->setValueExplicit($akun->first()->program, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                        $spreadsheet->getActiveSheet()->getCell('C' . $row)->setValueExplicit($akun->first()->kegiatan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                        $spreadsheet->getActiveSheet()->getCell('D' . $row)->setValueExplicit($akun->first()->kro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                        $spreadsheet->getActiveSheet()->getCell('E' . $row)->setValueExplicit($akun->first()->ro, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                        $spreadsheet->getActiveSheet()->getCell('F' . $row)->setValueExplicit($akun->first()->komponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                        $spreadsheet->getActiveSheet()->getCell('G' . $row)->setValueExplicit($akun->first()->subkomponen, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                        $spreadsheet->getActiveSheet()->getCell('H' . $row)->setValueExplicit($akun->first()->akun, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                        $spreadsheet->getActiveSheet()->getCell('L' . $row)->setValueExplicit('Akun', \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                                        $spreadsheet->getActiveSheet()
                                            ->setCellValue('I' . $row, $akun->sum('anggaran'))
                                            ->setCellValue('J' . $row, $realisasiAkun)
                                            ->setCellValue('K' . $row, $pengembalianAkun);
                                        $row++;
                                    }
                                }
                            }
                        }
                    }
                }
            }
            $spreadsheet->setActiveSheetIndexByName($name)->getStyle('I7:K' . $row)->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2);
            $spreadsheet->setActiveSheetIndexByName($name)->getStyle('A6:L' . $row)->applyFromArray($styleBorder);

            foreach ($spreadsheet->setActiveSheetIndexByName($name)->getColumnIterator() as $column) {
                $spreadsheet->setActiveSheetIndexByName($name)->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
            } 
        }
        $spreadsheet->setActiveSheetIndex(0);
        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Realisasi - ' . date('D, d M Y H:i:s') . '.xlsx"');
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
