<?php

namespace App\Http\Controllers;

use App\Models\pagu;
use App\Models\unit;
use App\Helper\Notification;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class PaguController extends Controller
{
    public function index()
    {
        if (!Gate::any(['KPA', 'Staf_KPA'])) {
            abort(403);
        }

        return view('pagu.index', [
            'data' => pagu::with(['unit'])->where('kodesatker', auth()->user()->satker)->where('tahun', session()->get('tahun'))->Order()->searchprogram()
                ->searchkegiatan()
                ->searchkro()
                ->searchro()
                ->searchkomponen()
                ->searchsubkomponen()
                ->searchakun()->paginate(15)->withQueryString(),
            'notifikasi' => Notification::Notif()

        ]);
    }

    public function create()
    {
        if (!Gate::any(['KPA', 'Staf_KPA'])) {
            abort(403);
        }

        return view('pagu.create', [
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function store(Request $request)
    {
        if (!Gate::any(['KPA', 'Staf_KPA'])) {
            abort(403);
        }

        $request->validate([
            'program' => 'required|min:2|max:2',
            'kegiatan' => 'required|min:4|max:4',
            'kro' => 'required|min:3|max:3',
            'ro' => 'required|min:3|max:3',
            'komponen' => 'required|min:3|max:3',
            'subkomponen' => 'required|min:1|max:1',
            'akun' => 'required|min:6|max:6',
            'anggaran' => 'required|numeric',
        ]);

        $request->validate([
            'kegiatan' => 'numeric',
            'ro' => 'numeric',
            'komponen' => 'numeric',
            'akun' => 'numeric',
        ]);

        pagu::create([
            'program' => $request->program,
            'kegiatan' => $request->kegiatan,
            'kro' => $request->kro,
            'ro' => $request->ro,
            'komponen' => $request->komponen,
            'subkomponen' => $request->subkomponen,
            'akun' => $request->akun,
            'anggaran' => $request->anggaran,
            'tahun' => session()->get('tahun'),
            'kodesatker' => auth()->user()->satker,
        ]);

        return redirect('/pagu')->with('berhasil', 'Data Berhasil Ditambahkan');
    }

    public function edit(pagu $pagu)
    {
        if (!Gate::any(['KPA', 'Staf_KPA'])) {
            abort(403);
        }

        return view('pagu.update', [
            'unit' => unit::where('kodesatker', auth()->user()->satker)->orderby('kodeunit')->get(),
            'data' => $pagu,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function update(Request $request, pagu $pagu)
    {
        if (!Gate::any(['KPA', 'Staf_KPA'])) {
            abort(403);
        }

        $request->validate([
            'program' => 'required|min:2|max:2',
            'kegiatan' => 'required|min:4|max:4',
            'kro' => 'required|min:3|max:3',
            'ro' => 'required|min:3|max:3',
            'komponen' => 'required|min:3|max:3',
            'subkomponen' => 'required|min:1|max:1',
            'akun' => 'required|min:6|max:6',
            'anggaran' => 'required|numeric',
        ]);

        $request->validate([
            'kegiatan' => 'numeric',
            'ro' => 'numeric',
            'komponen' => 'numeric',
            'akun' => 'numeric',
        ]);

        $pagu->update([
            'program' => $request->program,
            'kegiatan' => $request->kegiatan,
            'kro' => $request->kro,
            'ro' => $request->ro,
            'komponen' => $request->komponen,
            'subkomponen' => $request->subkomponen,
            'akun' => $request->akun,
            'program' => $request->program,
            'anggaran' => $request->anggaran,
        ]);

        return redirect('/pagu')->with('berhasil', 'Data Berhasil Diubah');
    }

    public function destroy(pagu $pagu)
    {
        if (!Gate::any(['KPA', 'Staf_KPA'])) {
            abort(403);
        }

        $pagu->delete();
        return redirect('/pagu');
    }

    public function import(Request $request)
    {
        if (!Gate::any(['KPA', 'Staf_KPA'])) {
            abort(403);
        }

        if ($request->all()) {

            $file = $request->file('berkas_excel');
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load($file);
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1, 1, '=counta(C1:C1000)');
            $sheetData = $spreadsheet->getSheetByName('pagu')->toArray();

            for ($i = 7; $i < $sheetData[0][0] + 6; $i++) {
                if ($sheetData[$i][2] === null || $sheetData[$i][3] === null || $sheetData[$i][4] === null || $sheetData[$i][5] === null || $sheetData[$i][6] === null || $sheetData[$i][7] === null || $sheetData[$i][8] === null || $sheetData[$i][9] === null) {
                    break;
                }
                pagu::create([
                    'program' => $sheetData[$i][2],
                    'kegiatan' => $sheetData[$i][3],
                    'kro' => $sheetData[$i][4],
                    'ro' => $sheetData[$i][5],
                    'komponen' => $sheetData[$i][6],
                    'subkomponen' => $sheetData[$i][7],
                    'akun' => $sheetData[$i][8],
                    'anggaran' => $sheetData[$i][9],
                    'tahun' => session()->get('tahun'),
                    'kodesatker' => auth()->user()->satker,
                    'kodeunit' => $sheetData[$i][10],
                ]);
            }
            return redirect('/pagu');
        }

        return view('pagu.import', [
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function template()
    {
        return response()->download(file: 'xlsx/upload_pagu.xlsx');
    }

    public function cetak()
    {
        if (!Gate::any(['KPA', 'Staf_KPA'])) {
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

        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(1)
            ->setTitle('ref_unit')
            ->setCellValue('B1', 'Kode')
            ->setCellValue('A1', 'Nama');
        $no = 2;
        foreach (unit::myunit()->search()->orderby('kodeunit')->get() as $item) {
            $spreadsheet
                ->setActiveSheetIndex(1)
                ->setCellValue('B' . $no, $item->kodeunit)
                ->setCellValue('A' . $no, $item->namaunit);
            $no++;
        }
        $spreadsheet->setActiveSheetIndex(1)->getProtection()->setSheet(true);
        $spreadsheet->setActiveSheetIndex(1)->getProtection()->setPassword('your_password');

        $spreadsheet->createSheet();
        $spreadsheet->setActiveSheetIndex(2)
            ->setTitle('Pagu')
            ->setCellValue('A1', 'ID')
            ->setCellValue('B1', 'Program')
            ->setCellValue('C1', 'Kegiatan')
            ->setCellValue('D1', 'Kro')
            ->setCellValue('E1', 'Ro')
            ->setCellValue('F1', 'Komponen')
            ->setCellValue('G1', 'Subkomponen')
            ->setCellValue('H1', 'Akun')
            ->setCellValue('I1', 'Anggaran')
            ->setCellValue('J1', 'Kode Satker')
            ->setCellValue('K1', 'Nama Unit')
            ->setCellValue('L1', 'Kode Unit');;
        $row = 2;
        foreach (pagu::where('kodesatker', auth()->user()->satker)->where('tahun', session()->get('tahun'))->Order()->get() as $item) {
            $spreadsheet
                ->setActiveSheetIndex(2)
                ->setCellValue('A' . $row, $item->id)
                ->setCellValue('B' . $row, $item->program)
                ->setCellValue('C' . $row, $item->kegiatan)
                ->setCellValue('D' . $row, $item->kro)
                ->setCellValue('E' . $row, $item->ro)
                ->setCellValue('F' . $row, $item->komponen)
                ->setCellValue('G' . $row, $item->subkomponen)
                ->setCellValue('H' . $row, $item->akun)
                ->setCellValue('I' . $row, $item->anggaran)
                ->setCellValue('J' . $row, $item->kodesatker)
                ->setCellValue('K' . $row, optional($item->unit)->namaunit)
                ->setCellValue('L' . $row, "=VLOOKUP(K{$row},'ref_unit'!A:B ,2, FALSE)");
            $row++;
            $spreadsheet->setActiveSheetIndex(2);
            $validation = $spreadsheet->getActiveSheet()->getCell('K' . $row)
                ->getDataValidation();
            $validation->setType(\PhpOffice\PhpSpreadsheet\Cell\DataValidation::TYPE_LIST);
            $validation->setAllowBlank(true);
            $validation->setShowDropDown(true);
            $validation->setFormula1('\'ref_unit\'!$A$2:$A$' . ($no - 1));
        }

        $spreadsheet->setActiveSheetIndex(0)
            ->setTitle('row')
            ->setCellValue('A1', 'num_row')
            ->setCellValue('B1', $row - 1)
            ->getProtection()->setSheet(true);
        $spreadsheet->setActiveSheetIndex(2)->getProtection()->setPassword('your_password');
        $spreadsheet->setActiveSheetIndex(2)->getStyle('A:K')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
        $spreadsheet->setActiveSheetIndex(2)->getStyle('I:I')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
        $spreadsheet->setActiveSheetIndex(2)->getStyle('I1:I1')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
        $spreadsheet->setActiveSheetIndex(2)->getStyle('A1:L1')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);

        $spreadsheet->setActiveSheetIndex(2)->getStyle('A1:L1')->applyFromArray($textcenter);
        $spreadsheet->setActiveSheetIndex(2)->getStyle('A1:L' . ($row - 1))->applyFromArray($styleBorder);


        foreach ($spreadsheet->setActiveSheetIndex(2)->getColumnIterator() as $column) {
            $spreadsheet->setActiveSheetIndex(2)->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }
        // ->getProtection()->setSheet(true);
        // $spreadsheet->setActiveSheetIndex(2)->getProtection()->setPassword('your_password');

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Pagu - ' . date('D, d M Y H:i:s') . '.xlsx"');
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

    public function massUpdate(Request $request)
    {
        if (!Gate::any(['KPA', 'Staf_KPA'])) {
            abort(403);
        }
        return view('pagu.mass-update', [
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function storeMassUpdate(Request $request)
    {
        if (!Gate::any(['KPA', 'Staf_KPA'])) {
            abort(403);
        }
        $file = $request->file('berkas_excel');
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($file);
        $row = $spreadsheet->getSheetByName('row')->getCell('B1')->getValue();
        $sheet = collect($spreadsheet->getSheetByName('Pagu')->rangeToArray('A2:L' . $row));
        $Errors = collect();
        foreach ($sheet as $item) {
            $row = collect([
                "id" => $item[0],
                "program" => $item[1],
                "kegiatan" => $item[2],
                "kro" => $item[3],
                "ro" => $item[4],
                "komponen" => $item[5],
                "subkomponen" => $item[6],
                "akun" => $item[7],
                "anggaran" => $item[8],
                "kodeunit" => $item[11],
            ]);
            $validator = Validator::make(
                $row->all(),
                [
                    'id' => 'required',
                    'program' => 'required|min:2|max:2',
                    'kegiatan' => 'required|min_digits:4|max_digits:4',
                    'kro' => 'required|min:3|max:3',
                    'ro' => 'required|min_digits:3|max_digits:3',
                    'komponen' => 'required|min_digits:3|max_digits:3',
                    'subkomponen' => 'required|min:1|max:2',
                    'akun' => 'required|min_digits:6|max_digits:6',
                    'anggaran' => ['required', 'regex:/^((\d*)|(\d{1,3}(,\d{3})+))(\.\d+)?$/'],
                    'kodeunit' => 'max_digits:2',
                ],
                [
                    'anggaran.regex' => 'Anggaran harus berupa angka',
                    'anggaran.required' => 'Anggaran harus diisi',
                    'id.required' => 'ID harus diisi',
                    'program.required' => 'Program harus diisi',
                    'kegiatan.required' => 'Kegiatan harus diisi',
                    'kro.required' => 'Kro harus diisi',
                    'ro.required' => 'Ro harus diisi',
                    'komponen.required' => 'Komponen harus diisi',
                    'subkomponen.required' => 'Subkomponen harus diisi',
                    'akun.required' => 'Akun harus diisi',
                    'kodeunit.required' => 'Unit harus diisi',
                    'program.min' => 'Anggaran minimal 2 karakter',
                    'program.max' => 'Anggaran minimal 2 karakter',
                    'kegiatan.min' => 'Anggaran minimal 4 karakter',
                    'kegiatan.max' => 'Anggaran minimal 4 karakter',
                    'kro.min' => 'Anggaran minimal 3 karakter',
                    'kro.max' => 'Anggaran minimal 3 karakter',
                    'ro.min' => 'Anggaran minimal 3 karakter',
                    'ro.max' => 'Anggaran minimal 3 karakter',
                    'komponen.min' => 'Anggaran minimal 3 karakter',
                    'komponen.max' => 'Anggaran minimal 3 karakter',
                    'subkomponen.min' => 'Anggaran minimal 1 karakter',
                    'subkomponen.max' => 'Anggaran minimal 2 karakter',
                    'akun.min' => 'Anggaran minimal 6 karakter',
                    'akun.max' => 'Anggaran minimal 6 karakter',
                    'kodeunit.min' => 'Anggaran minimal 2 karakter',
                    'kodeunit.max' => 'Anggaran minimal 2 karakter',
                ]
            );

            if ($validator->fails()) {
                $detail = (object) [];
                $detail->errors = (object) [];
                $errorMessage = json_decode($validator->errors()->toJson());
                if (isset($errorMessage->id)) {
                    $detail->errors->id =$item[0]." ". $errorMessage->id[0];
                } else {
                    $detail->errors->id = $item[0] ." ok";
                }
                if (isset($errorMessage->program)) {
                    $detail->errors->program = $errorMessage->program[0];
                } else {
                    $detail->errors->program = 'ok';
                }
                if (isset($errorMessage->kegiatan)) {
                    $detail->errors->kegiatan = $errorMessage->kegiatan[0];
                } else {
                    $detail->errors->kegiatan = 'ok';
                }
                if (isset($errorMessage->kro)) {
                    $detail->errors->kro = $errorMessage->kro[0];
                } else {
                    $detail->errors->kro = 'ok';
                }
                if (isset($errorMessage->ro)) {
                    $detail->errors->ro = $errorMessage->ro[0];
                } else {
                    $detail->errors->ro = 'ok';
                }
                if (isset($errorMessage->komponen)) {
                    $detail->errors->komponen = $errorMessage->komponen[0];
                } else {
                    $detail->errors->komponen = 'ok';
                }
                if (isset($errorMessage->subkomponen)) {
                    $detail->errors->subkomponen = $errorMessage->subkomponen[0];
                } else {
                    $detail->errors->subkomponen = 'ok';
                }
                if (isset($errorMessage->akun)) {
                    $detail->errors->akun = $errorMessage->akun[0];
                } else {
                    $detail->errors->akun = 'ok';
                }
                if (isset($errorMessage->anggaran)) {
                    $detail->errors->anggaran = $errorMessage->anggaran[0];
                } else {
                    $detail->errors->anggaran = 'ok';
                }
                if (isset($errorMessage->kodeunit)) {
                    $detail->errors->kodeunit = $errorMessage->kodeunit[0];
                } else {
                    $detail->errors->kodeunit = 'ok';
                }
                $detail->row = $item[0];
                $detail->status = false;
                $Errors->push($detail);
            }
        }

        if ($Errors->count() == 0) {
            foreach ($sheet as $item) {
                pagu::find($item[0])->update([
                    "program" => $item[1],
                    "kegiatan" => $item[2],
                    "kro" => $item[3],
                    "ro" => $item[4],
                    "komponen" => $item[5],
                    "subkomponen" => $item[6],
                    "akun" => $item[7],
                    "anggaran" => floatval(str_replace(',', '', $item[8])),
                    "kodeunit" => $item[11],
                ]);
            }
            return redirect('/pagu')->with('berhasil', 'Data Berhasil Diubah');
        }else{
            return redirect('/pagu/mass-update')->with('Errors', $Errors);
        }
    }
}
