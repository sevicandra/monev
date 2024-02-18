<?php

namespace App\Http\Controllers;

use App\Models\tagihan;
use App\Helper\Notification;
use Illuminate\Http\Request;
use Spipu\Html2Pdf\Html2Pdf;
use App\Models\DnpHonorarium;
use Illuminate\Support\Facades\Gate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class DnpHonorariumController extends Controller
{
    public function index(tagihan $tagihan)
    {
        if ($tagihan->status == 0) {
            if (!Gate::allows('Staf_PPK', auth()->user()->id)) {
                abort(403);
            }

            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
            $base_url='/tagihan-blbi';
        } elseif ($tagihan->status == 2) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
            $base_url= '/verifikasi';
        } else {
            abort(403);
        }
        return view('tagihan-blbi.dnp_honor.index', [
            'tagihan' => $tagihan,
            'data' => $tagihan->dnpHonor()->get(),
            'notifikasi' => Notification::Notif(),
            'base_url' => $base_url
        ]);
    }

    public function create(tagihan $tagihan)
    {
        if ($tagihan->status == 0) {
            if (!Gate::allows('Staf_PPK', auth()->user()->id)) {
                abort(403);
            }

            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
            $base_url='/tagihan-blbi';
        } elseif ($tagihan->status == 2) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
            $base_url= '/verifikasi';
        } else {
            abort(403);
        }
        return view('tagihan-blbi.dnp_honor.create', [
            'notifikasi' => Notification::Notif(),
            'tagihan' => $tagihan,
            'base_url' => $base_url
        ]);
    }

    public function store(Request $request, tagihan $tagihan)
    {
        if ($tagihan->status == 0) {
            if (!Gate::allows('Staf_PPK', auth()->user()->id)) {
                abort(403);
            }

            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
            $base_url='/tagihan-blbi';
        } elseif ($tagihan->status == 2) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
            $base_url= '/verifikasi';
        } else {
            abort(403);
        }

        $request->validate([
            'nama' => 'required',
            'nip' => 'required|numeric',
            'dasar' => 'required',
            'jabatan' => 'required',
            'gol' => 'required',
            'npwp' => 'required|numeric',
            'frekuensi' => 'required|numeric',
            'nilai' => ['required', 'regex:/^((\d*)|(\d{1,3}(,\d{3})+))(\.\d+)?$/'],
            'pajak' => ['required', 'regex:/^((\d*)|(\d{1,3}(,\d{3})+))(\.\d+)?$/'],
            'norek' => 'required|numeric',
            'namarek' => 'required',
            'bank' => 'required',
        ], [
            'nilai.regex' => 'Format Nilai Tidak Sesuai',
            'pajak.regex' => 'Format Nilai Tidak Sesuai',
            'nama.required' => 'Nama harus diisi',
            'nip.required' => 'NIP harus diisi',
            'dasar.required' => 'Dasar harus diisi',
            'jabatan.required' => 'Jabatan harus diisi',
            'gol.required' => 'Golongan harus diisi',
            'npwp.required' => 'NPWP harus diisi',
            'frekuensi.required' => 'Frekuensi harus diisi',
            'norek.required' => 'Nomor Rekening harus diisi',
            'namarek.required' => 'Nama Rekening harus diisi',
            'bank.required' => 'Bank harus diisi',
            'nip.numeric' => 'NIP harus angka',
            'npwp.numeric' => 'NPWP harus angka',
            'norek.numeric' => 'Nomor Rekening harus angka',
            'frekuensi.numeric' => 'Frekuensi harus angka',
            'nilai.required' => 'Nilai harus diisi',
            'pajak.required' => 'Pajak harus diisi',
        ]);
        $tagihan->dnpHonor()->create([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'dasar' => $request->dasar,
            'jabatan' => $request->jabatan,
            'gol' => $request->gol,
            'npwp' => $request->npwp,
            'frekuensi' => $request->frekuensi,
            'nilai' => floatval(str_replace(',', '', $request->nilai)),
            'bruto' => $request->frekuensi * floatval(str_replace(',', '', $request->nilai)),
            'pajak' => floatval(str_replace(',', '', $request->pajak)),
            'netto' => ($request->frekuensi * floatval(str_replace(',', '', $request->nilai))) - floatval(str_replace(',', '', $request->pajak)),
            'norek' => $request->norek,
            'namarek' => $request->namarek,
            'bank' => $request->bank,
        ]);
        return redirect('/tagihan-blbi/' . $tagihan->id . '/dnp-honorarium')->with('berhasil', 'DNP Honorarium berhasil ditambahkan');
    }

    public function edit(tagihan $tagihan, DnpHonorarium $dnp)
    {
        if ($tagihan->status == 0) {
            if (!Gate::allows('Staf_PPK', auth()->user()->id)) {
                abort(403);
            }

            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
            $base_url='/tagihan-blbi';
        } elseif ($tagihan->status == 2) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
            $base_url= '/verifikasi';
        } else {
            abort(403);
        }

        if ($tagihan->id != $dnp->tagihan_id) {
            abort(403);
        }

        return view('tagihan-blbi.dnp_honor.edit', [
            'tagihan' => $tagihan,
            'data' => $dnp,
            'notifikasi' => Notification::Notif(),
            'base_url' => $base_url
        ]);
    }

    public function update(Request $request, tagihan $tagihan, DnpHonorarium $dnp)
    {
        if ($tagihan->status == 0) {
            if (!Gate::allows('Staf_PPK', auth()->user()->id)) {
                abort(403);
            }

            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
            $base_url='/tagihan-blbi';
        } elseif ($tagihan->status == 2) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
            $base_url= '/verifikasi';
        } else {
            abort(403);
        }

        if ($tagihan->id != $dnp->tagihan_id) {
            abort(403);
        }

        $request->validate([
            'nama' => 'required',
            'nip' => 'required|numeric',
            'dasar' => 'required',
            'jabatan' => 'required',
            'gol' => 'required',
            'npwp' => 'required|numeric',
            'frekuensi' => 'required|numeric',
            'nilai' => ['required', 'regex:/^((\d*)|(\d{1,3}(,\d{3})+))(\.\d+)?$/'],
            'pajak' => ['required', 'regex:/^((\d*)|(\d{1,3}(,\d{3})+))(\.\d+)?$/'],
            'norek' => 'required|numeric',
            'namarek' => 'required',
            'bank' => 'required',
        ], [
            'nilai.regex' => 'Format Nilai Tidak Sesuai',
            'pajak.regex' => 'Format Nilai Tidak Sesuai',
            'nama.required' => 'Nama harus diisi',
            'nip.required' => 'NIP harus diisi',
            'dasar.required' => 'Dasar harus diisi',
            'jabatan.required' => 'Jabatan harus diisi',
            'gol.required' => 'Golongan harus diisi',
            'npwp.required' => 'NPWP harus diisi',
            'frekuensi.required' => 'Frekuensi harus diisi',
            'norek.required' => 'Nomor Rekening harus diisi',
            'namarek.required' => 'Nama Rekening harus diisi',
            'bank.required' => 'Bank harus diisi',
            'nip.numeric' => 'NIP harus angka',
            'npwp.numeric' => 'NPWP harus angka',
            'norek.numeric' => 'Nomor Rekening harus angka',
            'frekuensi.numeric' => 'Frekuensi harus angka',
            'nilai.required' => 'Nilai harus diisi',
            'pajak.required' => 'Pajak harus diisi',
        ]);

        $dnp->update([
            'nama' => $request->nama,
            'nip' => $request->nip,
            'dasar' => $request->dasar,
            'jabatan' => $request->jabatan,
            'gol' => $request->gol,
            'npwp' => $request->npwp,
            'frekuensi' => $request->frekuensi,
            'nilai' => floatval(str_replace(',', '', $request->nilai)),
            'bruto' => $request->frekuensi * floatval(str_replace(',', '', $request->nilai)),
            'pajak' => floatval(str_replace(',', '', $request->pajak)),
            'netto' => ($request->frekuensi * floatval(str_replace(',', '', $request->nilai))) - floatval(str_replace(',', '', $request->pajak)),
            'norek' => $request->norek,
            'namarek' => $request->namarek,
            'bank' => $request->bank,
        ]);
        return redirect('/tagihan-blbi/' . $tagihan->id . '/dnp-honorarium')->with('berhasil', 'DNP Honorarium berhasil diperbarui');
    }

    public function destroy(tagihan $tagihan, DnpHonorarium $dnp)
    {
        if ($tagihan->status == 0) {
            if (!Gate::allows('Staf_PPK', auth()->user()->id)) {
                abort(403);
            }

            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
            $base_url='/tagihan-blbi';
        } elseif ($tagihan->status == 2) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
            $base_url= '/verifikasi';
        } else {
            abort(403);
        }

        if ($tagihan->id != $dnp->tagihan_id) {
            abort(403);
        }

        $dnp->delete();
        return redirect('/tagihan-blbi/' . $tagihan->id . '/dnp-honorarium')->with('berhasil', 'DNP Honorarium berhasil dihapus');
    }

    public function import(tagihan $tagihan)
    {
        if ($tagihan->status == 0) {
            if (!Gate::allows('Staf_PPK', auth()->user()->id)) {
                abort(403);
            }

            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
            $base_url='/tagihan-blbi';
        } elseif ($tagihan->status == 2) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
            $base_url= '/verifikasi';
        } else {
            abort(403);
        }

        return view('tagihan-blbi.dnp_honor.import', [
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
            $base_url='/tagihan-blbi';
        } elseif ($tagihan->status == 2) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
            $base_url= '/verifikasi';
        } else {
            abort(403);
        }

        $file = $request->file('file');
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($file);
        $data = collect($spreadsheet->setActiveSheetIndex(0)->toArray())->skip(2);

        $Errors = collect();
        foreach ($data as $item) {
            $row = collect([
                'nama' => $item[1],
                'nip' => $item[2],
                'dasar' => $item[3],
                'jabatan' => $item[4],
                'gol' => $item[5],
                'npwp' => $item[6],
                'frekuensi' => $item[7],
                'nilai' => $item[8],
                'pajak' => $item[9],
                'norek' => $item[10],
                'namarek' => $item[11],
                'bank' => $item[12],
            ]);

            $validator = Validator::make(
                $row->all(),
                [
                    'nama' => 'required',
                    'nip' => 'required|numeric',
                    'dasar' => 'required',
                    'jabatan' => 'required',
                    'gol' => 'required',
                    'npwp' => 'required|numeric',
                    'frekuensi' => 'required|numeric',
                    'nilai' => ['required', 'regex:/^((\d*)|(\d{1,3}(,\d{3})+))(\.\d+)?$/'],
                    'pajak' => ['required', 'regex:/^((\d*)|(\d{1,3}(,\d{3})+))(\.\d+)?$/'],
                    'norek' => 'required|numeric',
                    'namarek' => 'required',
                    'bank' => 'required',
                ],
                [
                    'nilai.regex' => 'Format Nilai Tidak Sesuai',
                    'pajak.regex' => 'Format Nilai Tidak Sesuai',
                    'nama.required' => 'Nama harus diisi',
                    'nip.required' => 'NIP harus diisi',
                    'dasar.required' => 'Dasar harus diisi',
                    'jabatan.required' => 'Jabatan harus diisi',
                    'gol.required' => 'Golongan harus diisi',
                    'npwp.required' => 'NPWP harus diisi',
                    'frekuensi.required' => 'Frekuensi harus diisi',
                    'norek.required' => 'Nomor Rekening harus diisi',
                    'namarek.required' => 'Nama Rekening harus diisi',
                    'bank.required' => 'Bank harus diisi',
                    'nip.numeric' => 'NIP harus angka',
                    'npwp.numeric' => 'NPWP harus angka',
                    'norek.numeric' => 'Nomor Rekening harus angka',
                    'frekuensi.numeric' => 'Frekuensi harus angka',
                    'nilai.required' => 'Nilai harus diisi',
                    'pajak.required' => 'Pajak harus diisi',
                ]
            );

            if ($validator->fails()) {
                $detail = (object) [];
                $detail->errors = (object) [];
                $errorMessage = json_decode($validator->errors()->toJson());
                if (isset($errorMessage->nama)) {
                    $detail->errors->nama = $errorMessage->nama[0];
                } else {
                    $detail->errors->nama = 'ok';
                }
                if (isset($errorMessage->nip)) {
                    $detail->errors->nip = $errorMessage->nip[0];
                } else {
                    $detail->errors->nip = 'ok';
                }
                if (isset($errorMessage->dasar)) {
                    $detail->errors->dasar = $errorMessage->dasar[0];
                } else {
                    $detail->errors->dasar = 'ok';
                }
                if (isset($errorMessage->jabatan)) {
                    $detail->errors->jabatan = $errorMessage->jabatan[0];
                } else {
                    $detail->errors->jabatan = 'ok';
                }
                if (isset($errorMessage->gol)) {
                    $detail->errors->gol = $errorMessage->gol[0];
                } else {
                    $detail->errors->gol = 'ok';
                }
                if (isset($errorMessage->npwp)) {
                    $detail->errors->npwp = $errorMessage->npwp[0];
                } else {
                    $detail->errors->npwp = 'ok';
                }
                if (isset($errorMessage->frekuensi)) {
                    $detail->errors->frekuensi = $errorMessage->frekuensi[0];
                } else {
                    $detail->errors->frekuensi = 'ok';
                }
                if (isset($errorMessage->nilai)) {
                    $detail->errors->nilai = $errorMessage->nilai[0];
                } else {
                    $detail->errors->nilai = 'ok';
                }
                if (isset($errorMessage->pajak)) {
                    $detail->errors->pajak = $errorMessage->pajak[0];
                } else {
                    $detail->errors->pajak = 'ok';
                }
                if (isset($errorMessage->norek)) {
                    $detail->errors->norek = $errorMessage->norek[0];
                } else {
                    $detail->errors->norek = 'ok';
                }
                if (isset($errorMessage->namarek)) {
                    $detail->errors->namarek = $errorMessage->namarek[0];
                } else {
                    $detail->errors->namarek = 'ok';
                }
                if (isset($errorMessage->bank)) {
                    $detail->errors->bank = $errorMessage->bank[0];
                } else {
                    $detail->errors->bank = 'ok';
                }
                $detail->row = $item[0];
                $detail->status = false;
                $Errors->push($detail);
            } else {
                $detail = (object) [];
                $detail->errors = (object) [];
                $detail->errors->nama = 'ok';
                $detail->errors->nip = 'ok';
                $detail->errors->dasar = 'ok';
                $detail->errors->jabatan = 'ok';
                $detail->errors->gol = 'ok';
                $detail->errors->npwp = 'ok';
                $detail->errors->frekuensi = 'ok';
                $detail->errors->nilai = 'ok';
                $detail->errors->pajak = 'ok';
                $detail->errors->norek = 'ok';
                $detail->errors->namarek = 'ok';
                $detail->errors->bank = 'ok';
                $detail->row = $item[0];
                $detail->status = true;
                $Errors->push($detail);
            }
        }

        if ($Errors->min('status') === true) {
            foreach ($data as $item) {
                $tagihan->dnpHonor()->create([
                    'nama' => $item[1],
                    'nip' => $item[2],
                    'dasar' => $item[3],
                    'jabatan' => $item[4],
                    'gol' => $item[5],
                    'npwp' => $item[6],
                    'frekuensi' => $item[7],
                    'nilai' => floatval(str_replace(',', '', $item[8])),
                    'bruto' =>  $item[7] * floatval(str_replace(',', '', $item[8])),
                    'pajak' => floatval(str_replace(',', '', $item[9])),
                    'netto' => ($item[7] * floatval(str_replace(',', '', $item[8]))) - floatval(str_replace(',', '', $item[9])),
                    'norek' => $item[10],
                    'namarek' => $item[11],
                    'bank' => $item[12],
                ]);
            }
            return redirect('/tagihan-blbi/' . $tagihan->id . '/dnp-honorarium')->with('berhasil', 'Data DNP Honorarium Berhasil Ditambahkan');
        } else {
            return redirect('/tagihan-blbi/' . $tagihan->id . '/dnp-honorarium/import')
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
            ->setCellValue('D1', 'Dasar Pembayaran')
            ->setCellValue('E1', 'Jabatan')
            ->setCellValue('F1', 'Golongan')
            ->setCellValue('G1', 'NPWP')
            ->setCellValue('H1', 'Frekuensi')
            ->setCellValue('I1', 'Tarif')
            ->setCellValue('J1', 'Pajak')
            ->setCellValue('K1', 'Nomor Rekening')
            ->setCellValue('L1', 'Nama Rekening')
            ->setCellValue('M1', 'Bank');

        $spreadsheet->setActiveSheetIndex(0)
            ->setTitle('dnp')
            ->setCellValue('A2', '1')
            ->setCellValue('B2', 'xxxxxxxxx')
            ->setCellValue('C2', '199xxxxxxxxx')
            ->setCellValue('D2', 'ST-xx/xx/xxxx')
            ->setCellValue('E2', 'xxxxxx')
            ->setCellValue('F2', 'I/a, I/b, I/c, dll')
            ->setCellValue('G2', 'xxxxxxxx')
            ->setCellValue('H2', '1')
            ->setCellValue('I2', '950000')
            ->setCellValue('J2', '142500')
            ->setCellValue('K2', 'xxxxxxxx')
            ->setCellValue('L2', 'xxxxxxxx')
            ->setCellValue('M2', 'BNI/BRI/BSI/Mandiri/DLL')
            ->setCellValue('N2', 'Data contoh jangan di hapus');

        $spreadsheet->getActiveSheet()
            ->getStyle('A:M')->applyFromArray($textcenter);

        $spreadsheet
            ->setActiveSheetIndex(0)
            ->getStyle('A:M')
            ->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
        $spreadsheet
            ->setActiveSheetIndex(0)
            ->getStyle('I:J')
            ->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $spreadsheet
            ->setActiveSheetIndex(0)
            ->getStyle('A1:N1')
            ->getNumberFormat()
            ->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

        foreach ($spreadsheet->setActiveSheetIndex(0)->getColumnIterator() as $column) {
            $spreadsheet->setActiveSheetIndex(0)->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }

        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A2:N2')
            ->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $spreadsheet
            ->getActiveSheet()
            ->getStyle('A2:N2')
            ->getFill()
            ->getStartColor()
            ->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_YELLOW);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="DNP - Honorarium ' . date('D, d M Y H:i:s') . '.xlsx"');
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
            $base_url='/tagihan-blbi';
        } elseif ($tagihan->status == 2) {
            if (!Gate::allows('Validator', auth()->user()->id)) {
                abort(403);
            }

            if (!Gate::forUser(auth()->user())->allows('verifikaor_unit', $tagihan->unit)) {
                abort(403);
            }
            $base_url= '/verifikasi';
        } else {
            abort(403);
        }

        ob_start();
        $html = ob_get_clean();
        $html2pdf = new Html2Pdf('L', 'F4', 'en', false, 'UTF-8', array(10, 10, 10, 10));
        $html2pdf->addFont('Arial');
        $html2pdf->pdf->SetTitle('DNP Honorarium');
        $html2pdf->writeHTML(view('tagihan-blbi.dnp_honor.cetak',[
            'uraian'=>$tagihan->uraian,
            'ppk'=>$tagihan->ppk->nama,
            'data'=>$tagihan->dnpHonor()->get()
        ]));
        $html2pdf->output('DNP Perjadin.pdf', 'I');
    }
}
