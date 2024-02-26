<?php

namespace App\Http\Controllers;

use App\Models\Payroll;
use App\Models\tagihan;
use App\Models\DnpPerjadin;
use App\Helper\Notification;
use Illuminate\Http\Request;
use Spipu\Html2Pdf\Html2Pdf;
use Illuminate\Support\Facades\Gate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class DnpPerjadinController extends Controller
{
    public function index(tagihan $tagihan, DnpPerjadin $dnp, Request $request)
    {
        if ($tagihan->status == 0) {
            if (!Gate::allows('Staf_PPK', auth()->user()->id)) {
                abort(403);
            }

            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        } elseif ($tagihan->status == 2) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } elseif ($tagihan->status == 4) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } else {
            abort(403);
        }
        if ($tagihan->id != $dnp->tagihan_id) {
            abort(403);
        }
        $currentPath = $request->path();
        $parts = explode('/', $currentPath);
        $base_url = '/' . $parts[0];
        return view('dnp_perjadin.detail.index', [
            'dnp' => $dnp,
            'tagihan' => $tagihan,
            'notifikasi' => Notification::Notif(),
            'base_url' => $base_url
        ]);
    }

    public function edit(tagihan $tagihan,  DnpPerjadin $dnp, Request $request)
    {
        if ($tagihan->status == 0) {
            if (!Gate::allows('Staf_PPK', auth()->user()->id)) {
                abort(403);
            }

            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        } elseif ($tagihan->status == 2) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } elseif ($tagihan->status == 4) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } else {
            abort(403);
        }

        if ($tagihan->id != $dnp->tagihan_id) {
            abort(403);
        }
        $currentPath = $request->path();
        $parts = explode('/', $currentPath);
        $base_url = '/' . $parts[0];
        return view('dnp_perjadin.update', [
            'tagihan' => $tagihan,
            'data' => $dnp,
            'notifikasi' => Notification::Notif(),
            'base_url' => $base_url
        ]);
    }

    public function update(tagihan $tagihan, DnpPerjadin $dnp, Request $request)
    {
        if ($tagihan->status == 0) {
            if (!Gate::allows('Staf_PPK', auth()->user()->id)) {
                abort(403);
            }

            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        } elseif ($tagihan->status == 2) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } elseif ($tagihan->status == 4) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } else {
            abort(403);
        }

        if ($tagihan->id != $dnp->tagihan_id) {
            abort(403);
        }
        $currentPath = $request->path();
        $parts = explode('/', $currentPath);
        $base_url = '/' . $parts[0];
        $request->validate([
            'nama' => 'required',
            'nip' => 'required|max_digits:18|min_digits:10',
            'unit' => 'required',
            'st' => 'required',
            'lokasi' => 'required',
            'durasi' => 'required',
            'rekening' => 'required|numeric',
            'namarekening' => 'required',
            'bank' => 'required',
        ]);
        $dnp->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'unit' => $request->unit,
            'st' => $request->st,
            'lokasi' => $request->lokasi,
            'durasi' => $request->durasi,
            'norek' => $request->rekening,
            'namarek' => $request->namarekening,
            'bank' => $request->bank,
        ]);
        return redirect($base_url . '/' . $tagihan->id . '/dnp-perjadin')->with('berhasil', 'DNP Perjadin Berhasiltahkan');
    }

    public function updateDetail(tagihan $tagihan, DnpPerjadin $dnp, Request $request)
    {
        if ($tagihan->status == 0) {
            if (!Gate::allows('Staf_PPK', auth()->user()->id)) {
                abort(403);
            }

            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        } elseif ($tagihan->status == 2) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } elseif ($tagihan->status == 4) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } else {
            abort(403);
        }
        if ($tagihan->id != $dnp->tagihan_id) {
            abort(403);
        }
        $currentPath = $request->path();
        $parts = explode('/', $currentPath);
        $base_url = '/' . $parts[0];
        $biayaAngkutan = null;
        $biayaTransportasiLain = null;
        $uangHarian = null;
        $Penginapan = null;
        $uangRepresentatif = null;

        if ($request->namaBiayaAngkutan) {
            for ($i = 0; $i < count($request->namaBiayaAngkutan); $i++) {
                $biayaAngkutan[] = [
                    "nama" => $request->namaBiayaAngkutan[$i],
                    "nilai" => floatval(str_replace(',', '', $request->nilaiBiayaAngkutan[$i])),
                    "keterangan" => $request->keteranganBiayaAngkutan[$i]
                ];
            }
        }
        if ($request->namaBiayaTransportasiLain) {
            for ($i = 0; $i < count($request->namaBiayaTransportasiLain); $i++) {
                $biayaTransportasiLain[] = [
                    "nama" => $request->namaBiayaTransportasiLain[$i],
                    "nilai" => floatval(str_replace(',', '', $request->nilaiBiayaTransportasiLain[$i])),
                    "keterangan" => $request->keteranganBiayaTransportasiLain[$i]
                ];
            }
        }
        if ($request->frekuensiUangHarian) {
            for ($i = 0; $i < count($request->frekuensiUangHarian); $i++) {
                $uangHarian[] = [
                    "frekuensi" => $request->frekuensiUangHarian[$i],
                    "nilai" => floatval(str_replace(',', '', $request->nilaiUangHarian[$i])),
                    "keterangan" => $request->keteranganUangHarian[$i]
                ];
            }
        }
        if ($request->frekuensiPenginapan) {
            for ($i = 0; $i < count($request->frekuensiPenginapan); $i++) {
                $Penginapan[] = [
                    "frekuensi" => $request->frekuensiPenginapan[$i],
                    "nilai" => floatval(str_replace(',', '', $request->nilaiPenginapan[$i])),
                    "keterangan" => $request->keteranganPenginapan[$i]
                ];
            }
        }
        if ($request->frekuensiRepresentatif) {
            for ($i = 0; $i < count($request->frekuensiRepresentatif); $i++) {
                $uangRepresentatif[] = [
                    "frekuensi" => $request->frekuensiRepresentatif[$i],
                    "nilai" => floatval(str_replace(',', '', $request->nilaiRepresentatif[$i])),
                    "keterangan" => $request->keteranganRepresentatif[$i]
                ];
            }
        }

        $dnp->update([
            'transport' => json_encode($biayaAngkutan) ?? json_encode([]),
            'transportLain' => json_encode($biayaTransportasiLain) ?? json_encode([]),
            'uangharian' => json_encode($uangHarian) ?? json_encode([]),
            'penginapan' => json_encode($Penginapan) ?? json_encode([]),
            'representatif' => json_encode($uangRepresentatif) ?? json_encode([]),
        ]);

        return redirect($base_url . '/' . $tagihan->id . '/dnp-perjadin/' . $dnp->id)->with('berhasil', 'Data dnp perjadin diperbarui');
    }

    public function import(tagihan $tagihan, Request $request)
    {
        if ($tagihan->status == 0) {
            if (!Gate::allows('Staf_PPK', auth()->user()->id)) {
                abort(403);
            }

            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        } elseif ($tagihan->status == 2) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } elseif ($tagihan->status == 4) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } else {
            abort(403);
        }
        $currentPath = $request->path();
        $parts = explode('/', $currentPath);
        $base_url = '/' . $parts[0];
        return view('dnp_perjadin.import.index', [
            'tagihan' => $tagihan,
            'notifikasi' => Notification::Notif(),
            'base_url' => $base_url
        ]);
    }

    public function importStore(tagihan $tagihan, Request $request)
    {
        if ($tagihan->status == 0) {
            if (!Gate::allows('Staf_PPK', auth()->user()->id)) {
                abort(403);
            }

            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        } elseif ($tagihan->status == 2) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } elseif ($tagihan->status == 4) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } else {
            abort(403);
        }
        $currentPath = $request->path();
        $parts = explode('/', $currentPath);
        $base_url = '/' . $parts[0];
        $file = $request->file('file');
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($file);
        $data = collect($spreadsheet->setActiveSheetIndex(0)->toArray())->skip(2);

        $Errors = collect();
        foreach ($data as $item) {
            $row = collect([
                'NAMA' => $item[1],
                'NIP' => $item[2],
                'Unit_Kerja' => $item[3],
                'Surat_Tugas' => $item[4],
                'Lokasi' => $item[5],
                'Durasi' => $item[6],
                'Frekuensi_1' => $item[7],
                'Tarif_Uang_Harian_1' => $item[8],
                'Frekuensi_2' => $item[9],
                'Tarif_Uang_Harian 2' => $item[10],
                'Frekuensi_3' => $item[11],
                'Tarif_Uang_Harian_3' => $item[12],
                'Frekuensi_Representatif' => $item[13],
                'Uang_Representatif' => $item[14],
                'Transport' => $item[15],
                'Transport_Lain' => $item[16],
                'Frekuensi_Hotel' => $item[17],
                'Hotel' => $item[18],
                'Nomor_Rekening' => $item[19],
                'Nama_Rekening' => $item[20],
                'Bank' => $item[21],
            ]);

            $validator = Validator::make(
                $row->all(),
                [
                    'NAMA' => 'required',
                    'NIP' => 'required|numeric',
                    'Unit_Kerja' => 'required',
                    'Surat_Tugas' => 'required',
                    'Lokasi' => 'required',
                    'Durasi' => 'required',
                    'Nomor_Rekening' => 'required|numeric',
                    'Bank' => 'required',
                    'Nama_Rekening' => 'required',
                ],
                [
                    'NIP.required' => 'NIP/NIK/NRP/DLL tidak boleh kosong',
                    'NAMA.required' => 'Nama tidak boleh kosong',
                    'Unit_Kerja.required' => 'Unit Kerja tidak boleh kosong',
                    'Surat_Tugas.required' => 'Surat Tugas tidak boleh kosong',
                    'Lokasi.required' => 'Lokasi tidak boleh kosong',
                    'Durasi.required' => 'Durasi tidak boleh kosong',
                    'Nomor_Rekening.required' => 'Nomor Rekening tidak boleh kosong',
                    'Bank.required' => 'Bank tidak boleh kosong',
                    'Nama_Rekening.required' => 'Nama Rekening tidak boleh kosong',
                    'Nomor_Rekening.numeric' => 'Nomor Rekening harus angka',
                    'NIP.numeric' => 'Nomor Rekening harus angka',
                ],
            );

            if ($validator->fails()) {
                $detail = (object) [];
                $detail->errors = (object) [];
                $errorMessage = json_decode($validator->errors()->toJson());
                if (isset($errorMessage->NIP)) {
                    $detail->errors->NIP = $errorMessage->NIP[0];
                } else {
                    $detail->errors->NIP = 'ok';
                }
                if (isset($errorMessage->NAMA)) {
                    $detail->errors->NAMA = $errorMessage->NAMA[0];
                } else {
                    $detail->errors->NAMA = 'ok';
                }
                if (isset($errorMessage->Unit_Kerja)) {
                    $detail->errors->Unit_Kerja = $errorMessage->Unit_Kerja[0];
                } else {
                    $detail->errors->Unit_Kerja = 'ok';
                }
                if (isset($errorMessage->Surat_Tugas)) {
                    $detail->errors->Surat_Tugas = $errorMessage->Surat_Tugas[0];
                } else {
                    $detail->errors->Surat_Tugas = 'ok';
                }
                if (isset($errorMessage->Lokasi)) {
                    $detail->errors->Lokasi = $errorMessage->Lokasi[0];
                } else {
                    $detail->errors->Lokasi = 'ok';
                }
                if (isset($errorMessage->Durasi)) {
                    $detail->errors->Durasi = $errorMessage->Durasi[0];
                } else {
                    $detail->errors->Durasi = 'ok';
                }
                if (isset($errorMessage->Nomor_Rekening)) {
                    $detail->errors->Nomor_Rekening = $errorMessage->Nomor_Rekening[0];
                } else {
                    $detail->errors->Nomor_Rekening = 'ok';
                }
                if (isset($errorMessage->Nama_Rekening)) {
                    $detail->errors->Nama_Rekening = $errorMessage->Nama_Rekening[0];
                } else {
                    $detail->errors->Nama_Rekening = 'ok';
                }
                if (isset($errorMessage->Bank)) {
                    $detail->errors->Bank = $errorMessage->Bank[0];
                } else {
                    $detail->errors->Bank = 'ok';
                }
                $detail->row = $item[0];
                $detail->status = false;
                $Errors->push($detail);
            } else {
                $detail = (object) [];
                $detail->errors = (object) [];
                $detail->errors->NIP = 'ok';
                $detail->errors->NAMA = 'ok';
                $detail->errors->Unit_Kerja = 'ok';
                $detail->errors->Surat_Tugas = 'ok';
                $detail->errors->Lokasi = 'ok';
                $detail->errors->Durasi = 'ok';
                $detail->errors->Nomor_Rekening = 'ok';
                $detail->errors->Nama_Rekening = 'ok';
                $detail->errors->Bank = 'ok';
                $detail->row = $item[0];
                $detail->status = true;
                $Errors->push($detail);
            }
        }

        if ($Errors->min('status') === true) {
            foreach ($data as $item) {
                $transport = [];
                $transportLain = [];
                $uangharian = [];
                $uangharian = [];
                $uangharian = [];
                $penginapan = [];
                $representatif = [];
                $transport[] = [
                    "nama" => "Transport PP",
                    "nilai" => floatval(str_replace(',', '', $item[15])),
                    "keterangan" => null
                ];
                $transportLain[] = [
                    "nama" => "Transport Lain",
                    "nilai" => floatval(str_replace(',', '', $item[16])),
                    "keterangan" => null
                ];
                $uangharian[] = [
                    "frekuensi" => $item[7],
                    "nilai" => floatval(str_replace(',', '', $item[8])),
                    "keterangan" => null
                ];
                $uangharian[] = [
                    "frekuensi" => $item[9],
                    "nilai" => floatval(str_replace(',', '', $item[10])),
                    "keterangan" => null
                ];
                $uangharian[] = [
                    "frekuensi" => $item[11],
                    "nilai" => floatval(str_replace(',', '', $item[12])),
                    "keterangan" => null
                ];
                $penginapan[] = [
                    "frekuensi" => $item[17],
                    "nilai" => floatval(str_replace(',', '', $item[18])),
                    "keterangan" => null
                ];
                $representatif[] = [
                    "frekuensi" => $item[13],
                    "nilai" => floatval(str_replace(',', '', $item[14])),
                    "keterangan" => null
                ];
                DnpPerjadin::create([
                    'tagihan_id' => $tagihan->id,
                    'nama' => $item[1],
                    'nip' => $item[2],
                    'unit' => $item[3],
                    'st' => $item[4],
                    'lokasi' => $item[5],
                    'durasi' => $item[6],
                    'norek' => $item[19],
                    'namarek' => $item[20],
                    'bank' => $item[21],
                    'transport' => json_encode($transport),
                    'transportLain' => json_encode($transportLain),
                    'uangharian' => json_encode($uangharian),
                    'penginapan' => json_encode($penginapan),
                    'representatif' => json_encode($representatif),
                ]);
            }
            return redirect($base_url . '/' . $tagihan->id . '/dnp-perjadin')->with('berhasil', 'Data DNP Perjadin Berhasil Ditambahkan');
        } else {
            return redirect($base_url . '/' . $tagihan->id . '/dnp-perjadin/import')
                ->with('gagal', 'Data gagal ditambahkan. Silahkan cek kembali.')
                ->with('Errors', collect($Errors));
        }
    }

    public function template()
    {
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

        $spreadsheet->setActiveSheetIndex(0)
            ->setTitle('dnp')
            ->setCellValue('A1', 'No')
            ->setCellValue('B1', 'Nama')
            ->setCellValue('C1', 'NIP/NIK/NRP/DLL')
            ->setCellValue('D1', 'Unit Kerja')
            ->setCellValue('E1', 'Surat Tugas')
            ->setCellValue('F1', 'Lokasi (Asal - Tujuan)')
            ->setCellValue('G1', 'Durasi')
            ->setCellValue('H1', 'Frekuensi 1')
            ->setCellValue('I1', 'Tarif Uang Harian 1')
            ->setCellValue('J1', 'Frekuensi 2')
            ->setCellValue('K1', 'Tarif Uang Harian 2')
            ->setCellValue('L1', 'Frekuensi 3')
            ->setCellValue('M1', 'Tarif Uang Harian 3')
            ->setCellValue('N1', 'Frekuensi Representatif')
            ->setCellValue('O1', 'Tarif Uang Representatif')
            ->setCellValue('P1', 'Transport')
            ->setCellValue('Q1', 'Transport Lain-Lain')
            ->setCellValue('R1', 'Frekuensi Hotel')
            ->setCellValue('S1', 'Tarif Hotel')
            ->setCellValue('T1', 'Nomor Rekening')
            ->setCellValue('U1', 'Nama Rekening')
            ->setCellValue('V1', 'Bank');

        $spreadsheet->setActiveSheetIndex(0)
            ->setTitle('dnp')
            ->setCellValue('A2', '1')
            ->setCellValue('B2', 'xxxxxxxxx')
            ->setCellValue('C2', '199xxxxxxxxx')
            ->setCellValue('D2', 'DJKN')
            ->setCellValue('E2', 'ST-xx/xx/xxxx')
            ->setCellValue('F2', 'Jakarta - Bogor')
            ->setCellValue('G2', 'xx Januari  s.d. xx Januari ')
            ->setCellValue('H2', '1')
            ->setCellValue('I2', '344000')
            ->setCellValue('J2', '1')
            ->setCellValue('K2', '344000')
            ->setCellValue('L2', '1')
            ->setCellValue('M2', '344000')
            ->setCellValue('N2', '1')
            ->setCellValue('O2', '150000')
            ->setCellValue('P2', '1000000')
            ->setCellValue('Q2', '100000')
            ->setCellValue('R2', '1')
            ->setCellValue('S2', '600000')
            ->setCellValue('T2', 'xxxxxxxx')
            ->setCellValue('U2', 'xxxxxxxx')
            ->setCellValue('V2', 'BNI/BRI/BSI/Mandiri/DLL')
            ->setCellValue('W2', 'Data contoh jangan di hapus');

        $spreadsheet->getActiveSheet()
            ->getStyle('A:V')->applyFromArray($textcenter);

        $spreadsheet
            ->setActiveSheetIndex(0)
            ->getStyle('A:V')
            ->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
        $spreadsheet
            ->setActiveSheetIndex(0)
            ->getStyle('I:I')
            ->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $spreadsheet
            ->setActiveSheetIndex(0)
            ->getStyle('K:K')
            ->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $spreadsheet
            ->setActiveSheetIndex(0)
            ->getStyle('M:M')
            ->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $spreadsheet
            ->setActiveSheetIndex(0)
            ->getStyle('O:Q')
            ->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $spreadsheet
            ->setActiveSheetIndex(0)
            ->getStyle('S:S')
            ->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $spreadsheet
            ->setActiveSheetIndex(0)
            ->getStyle('A1:V1')
            ->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

        foreach ($spreadsheet->setActiveSheetIndex(0)->getColumnIterator() as $column) {
            $spreadsheet->setActiveSheetIndex(0)->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A2:W2')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A2:W2')
            ->getFill()
            ->getStartColor()
            ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_YELLOW);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="DNP - Perjadin ' . date('D, d M Y H:i:s') . '.xlsx"');
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

    public function cetak(tagihan $tagihan)
    {
        if ($tagihan->status == 0) {
            if (!Gate::allows('Staf_PPK', auth()->user()->id)) {
                abort(403);
            }

            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        } elseif ($tagihan->status == 2) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } elseif ($tagihan->status == 4) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } else {
            abort(403);
        }

        ob_start();
        $html = ob_get_clean();
        $html2pdf = new Html2Pdf('L', 'F4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('DNP Perjadin');
        $html2pdf->writeHTML(view('dnp_perjadin.cetak.dnp', [
            'uraian' => $tagihan->uraian,
            'ppk' => $tagihan->ppk->nama,
            'data' => $tagihan->dnpperjadin()->get()
        ]));
        $html2pdf->output('DNP Perjadin.pdf', 'I');
    }

    public function cetakKuitansi(tagihan $tagihan, DnpPerjadin $dnp)
    {
        if ($tagihan->status == 0) {
            if (!Gate::allows('Staf_PPK', auth()->user()->id)) {
                abort(403);
            }

            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        } elseif ($tagihan->status == 2) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } elseif ($tagihan->status == 4) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } else {
            abort(403);
        }

        if ($tagihan->id != $dnp->tagihan_id) {
            abort(403);
        }
        // NumberToWord::toWords($num);
        ob_start();
        $html = ob_get_clean();
        $html2pdf = new Html2Pdf('P', 'F4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('DNP Perjadin');
        $html2pdf->writeHTML(view('dnp_perjadin.cetak.kuitansi', [
            'ppk' => $tagihan->ppk,
            'dnp' => $dnp,
            // 'data'=>$tagihan->dnpperjadin()->get()
        ]));
        $html2pdf->output('DNP Perjadin.pdf', 'I');
    }

    public function dnpPerjadin(tagihan $tagihan, Request $request)
    {
        if ($tagihan->status == 0) {
            if (!Gate::allows('Staf_PPK', auth()->user()->id)) {
                abort(403);
            }

            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        } elseif ($tagihan->status == 2) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } elseif ($tagihan->status == 4) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } else {
            abort(403);
        }
        $currentPath = $request->path();
        $parts = explode('/', $currentPath);
        $base_url = '/' . $parts[0];
        return view('dnp_perjadin.index', [
            'tagihan' => $tagihan,
            'data' => $tagihan->dnpperjadin()->paginate(15),
            'notifikasi' => Notification::Notif(),
            'base_url' => $base_url
        ]);
    }

    public function dnpPerjadinCreate(tagihan $tagihan, Request $request)
    {
        if ($tagihan->status == 0) {
            if (!Gate::allows('Staf_PPK', auth()->user()->id)) {
                abort(403);
            }

            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        } elseif ($tagihan->status == 2) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } elseif ($tagihan->status == 4) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } else {
            abort(403);
        }
        $currentPath = $request->path();
        $parts = explode('/', $currentPath);
        $base_url = '/' . $parts[0];
        return view('dnp_perjadin.create', [
            'tagihan' => $tagihan,
            'notifikasi' => Notification::Notif(),
            'base_url' => $base_url
        ]);
    }

    public function dnpPerjadinStore(tagihan $tagihan, Request $request)
    {
        if ($tagihan->status == 0) {
            if (!Gate::allows('Staf_PPK', auth()->user()->id)) {
                abort(403);
            }

            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        } elseif ($tagihan->status == 2) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } elseif ($tagihan->status == 4) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } else {
            abort(403);
        }
        $currentPath = $request->path();
        $parts = explode('/', $currentPath);
        $base_url = '/' . $parts[0];
        $request->validate([
            'nama' => 'required',
            'nip' => 'required|max_digits:18|min_digits:10',
            'unit' => 'required',
            'st' => 'required',
            'lokasi' => 'required',
            'durasi' => 'required',
            'rekening' => 'required|numeric',
            'namarekening' => 'required',
            'bank' => 'required',
        ]);

        DnpPerjadin::create([
            'tagihan_id' => $tagihan->id,
            'nama' => $request->nama,
            'nip' => $request->nip,
            'unit' => $request->unit,
            'st' => $request->st,
            'lokasi' => $request->lokasi,
            'durasi' => $request->durasi,
            'norek' => $request->rekening,
            'namarek' => $request->namarekening,
            'bank' => $request->bank,
            'transport' => json_encode([]),
            'transportLain' => json_encode([]),
            'uangharian' => json_encode([]),
            'penginapan' => json_encode([]),
            'representatif' => json_encode([]),
        ]);
        return redirect($base_url . '/' . $tagihan->id . '/dnp-perjadin')->with('success', 'DNP Perjadin Berhasiltahkan');
    }

    public function Destroy(tagihan $tagihan, DnpPerjadin $dnp)
    {
        if ($tagihan->status == 0) {
            if (!Gate::allows('Staf_PPK', auth()->user()->id)) {
                abort(403);
            }

            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        } elseif ($tagihan->status == 2) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } elseif ($tagihan->status == 4) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } else {
            abort(403);
        }
        if ($tagihan->id != $dnp->tagihan_id) {
            abort(403);
        }
        $dnp->delete();
        return back()->with('berhasil', 'DNP Perjadin Berhasil di Hapus');
    }

    public function createPayroll(tagihan $tagihan)
    {
        if ($tagihan->status == 0) {
            if (!Gate::allows('Staf_PPK', auth()->user()->id)) {
                abort(403);
            }

            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        } elseif ($tagihan->status == 2) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } elseif ($tagihan->status == 4) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
        } else {
            abort(403);
        }

        $tagihan->payroll()->delete();
        foreach ($tagihan->dnpperjadin()->get()->groupBy('norek') as $payroll) {
            $a = 0;
            $b = 0;
            $c = 0;
            $d = 0;
            $e = 0;

            foreach ($payroll as $item) {
                $a += collect(json_decode($item->transport))->sum('nilai');
                $b += collect(json_decode($item->transportLain))->sum('nilai');
                foreach (collect(json_decode($item->uangharian)) as $uangharian) {
                    $c += $uangharian->frekuensi * $uangharian->nilai;
                }
                foreach (collect(json_decode($item->penginapan)) as $penginapan) {
                    $d += $penginapan->frekuensi * $penginapan->nilai;
                }
                foreach (collect(json_decode($item->representatif)) as $representatif) {
                    $e += $representatif->frekuensi * $representatif->nilai;
                }

            }

            if ($payroll->first()->bank == "BNI") {
                $admin = 0;
            } else {
                $admin = 2900;
            }
            Payroll::create([
                'nama' => $payroll->first()->nama,
                'norek' => $payroll->first()->norek,
                'bank' => $payroll->first()->bank,
                'bruto' => $a + $b + $c + $d + $e,
                'pajak' => 0,
                'admin' => $admin,
                'tagihan_id' => $tagihan->id,
                'netto' => $a + $b + $c + $d + $e - $admin,
            ]);
        }

        return back()->with('berhasil', 'Data Payroll Berhasil Di Generate');
    }
}
