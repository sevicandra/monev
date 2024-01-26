<?php

namespace App\Http\Controllers;

use App\Models\spm;
use App\Models\tagihan;
use App\Helper\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class CleansingSppController extends Controller
{
    public function index()
    {
        if (!Gate::any(['sys_admin', 'admin_satker'], auth()->user()->id)) {
            abort(403);
        }
        return view("data_cleansing.SPP.index", [
            'data' => tagihan::cleansingSPP()->search()->order()->paginate(15)->withQueryString(),
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function download()
    {
        if (!Gate::any(['sys_admin', 'admin_satker'], auth()->user()->id)) {
            abort(403);
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
        $tagihan = tagihan::cleansingSPP();

        $spreadsheet->setActiveSheetIndex(0)
            ->setTitle('row')
            ->setCellValue('A1', 'num_row')
            ->setCellValue('B1', $tagihan->count())
            ->getProtection()->setSheet(true);
        $spreadsheet->setActiveSheetIndex(0)->getProtection()->setPassword('your_password');

        $dataSheet = $spreadsheet->createSheet();
        $dataSheet->setTitle('data');
        $spreadsheet->setActiveSheetIndex(1)
            ->setCellValue('B3', 'Daftar SPP Belum Input SP2D')
            ->mergeCells('B3:I3')
            ->setCellValue('B4', 'Satuan Kerja ' . auth()->user()->satker)
            ->mergeCells('B4:I4')
            ->setCellValue('B5', 'Periode ' . date('D, d M Y H:i:s'))
            ->mergeCells('B5:I5');
        $spreadsheet->getActiveSheet()
            ->getStyle('B3:B5')->applyFromArray($textcenter);
        $spreadsheet->setActiveSheetIndex(1)
            ->setCellValue('B7', 'No.')
            ->setCellValue('C7', 'ID')
            ->setCellValue('D7', 'Nomor Tagihan')
            ->setCellValue('E7', 'Tanggal Tagihan')
            ->setCellValue('F7', 'Nomor SPM')
            ->setCellValue('G7', 'Tanggal SPM')
            ->setCellValue('H7', 'Nomor SP2D')
            ->setCellValue('I7', 'Tanggal SP2D');;
        $spreadsheet->getActiveSheet()
            ->getStyle('B7:I7')->applyFromArray($textcenter);
        $i = 0;
        foreach ($tagihan->get() as $item) {
            $i++;
            $spreadsheet->setActiveSheetIndex(1)
                ->setCellValue('B' . ($i + 7), $i)
                ->setCellValue('E' . ($i + 7), $item->tgltagihan);
            $spreadsheet->setActiveSheetIndex(1)->getCell('C' . ($i + 7))->setValueExplicit($item->id, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
            $spreadsheet->setActiveSheetIndex(1)->getCell('D' . ($i + 7))->setValueExplicit($item->notagihan, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
            if ($item->spm) {
                $spreadsheet->setActiveSheetIndex(1)->getCell('F' . ($i + 7))->setValueExplicit($item->spm->no_spm, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $spreadsheet->setActiveSheetIndex(1)->getCell('G' . ($i + 7))->setValueExplicit($item->spm->tanggal_spm, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $spreadsheet->setActiveSheetIndex(1)->getCell('H' . ($i + 7))->setValueExplicit($item->spm->nomor_sp2d, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
                $spreadsheet->setActiveSheetIndex(1)->getCell('I' . ($i + 7))->setValueExplicit($item->spm->tanggal_sp2d, \PhpOffice\PhpSpreadsheet\Cell\DataType::TYPE_STRING2);
            }
            $spreadsheet->setActiveSheetIndex(1)->getStyle('C' . ($i + 7))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            $spreadsheet->setActiveSheetIndex(1)->getStyle('D' . ($i + 7))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            $spreadsheet->setActiveSheetIndex(1)->getStyle('E' . ($i + 7))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            $spreadsheet->setActiveSheetIndex(1)->getStyle('F' . ($i + 7))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            $spreadsheet->setActiveSheetIndex(1)->getStyle('G' . ($i + 7))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            $spreadsheet->setActiveSheetIndex(1)->getStyle('H' . ($i + 7))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
            $spreadsheet->setActiveSheetIndex(1)->getStyle('I' . ($i + 7))->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_TEXT);
        }
        $spreadsheet->setActiveSheetIndex(1)->getStyle('B7:I' . ($i + 7))->applyFromArray($styleBorder);

        foreach ($spreadsheet->setActiveSheetIndex(1)->getColumnIterator() as $column) {
            $spreadsheet->setActiveSheetIndex(1)->getColumnDimension($column->getColumnIndex())->setAutoSize(true);
        }
        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="SPP -' . date('D, d M Y H:i:s') . '.xlsx"');
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

    public function import()
    {
        if (!Gate::any(['sys_admin', 'admin_satker'], auth()->user()->id)) {
            abort(403);
        }
        return view('data_cleansing.SPP.import',[
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function store(Request $request)
    {
        if (!Gate::any(['sys_admin', 'admin_satker'], auth()->user()->id)) {
            abort(403);
        }
        $file = $request->file('file');
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($file);
        $row = $spreadsheet->getSheetByName('row')->getCell('B1')->getValue();
        $sheet = collect($spreadsheet->getSheetByName('data')->rangeToArray('B8:I' . ($row + 7)));
        $errors = collect();
        foreach ($sheet as $item) {
            $row = collect([
                'tagihan_id' => $item[1],
                'no_spm' => $item[4],
                'tanggal_spm' => $item[5],
                'nomor_sp2d' => $item[6],
                'tanggal_sp2d' => $item[7],
            ]);
            $validator = Validator::make($row->all(), [
                'tagihan_id' => 'required',
                'no_spm' => 'required|min_digits:5|max_digits:5',
                'tanggal_spm' => 'required|date_format:Y-m-d',
                'nomor_sp2d' => 'required|min_digits:15|max_digits:15',
                'tanggal_sp2d' => 'required|date_format:Y-m-d',
            ], [
                'tagihan_id.required' => 'ID tidak boleh kosong',
                'no_spm.required' => 'Nomor SPM tidak boleh kosong',
                'no_spm.min_digits' => 'Nomor SPM harus 5 digit',
                'no_spm.max_digits' => 'Nomor SPM harus 5 digit',
                'tanggal_spm.required' => 'Tanggal SPM tidak boleh kosong',
                'tanggal_spm.date_format' => 'Format Tanggal SPM salah',
                'nomor_sp2d.required' => 'Nomor SP2D tidak boleh kosong',
                'nomor_sp2d.min_digits' => 'Nomor SP2D harus 15 digit',
                'nomor_sp2d.max_digits' => 'Nomor SP2D harus 15 digit',
                'tanggal_sp2d.required' => 'Tanggal SP2D tidak boleh kosong',
                'tanggal_sp2d.date_format' => 'Format Tanggal SP2D salah',
            ]);
            if ($validator->fails()) {
                $detail = (object) [];
                $detail->errors = (object) [];
                $errorMessage = json_decode($validator->errors()->toJson());
                if (isset($errorMessage->tagihan_id)) {
                    $detail->errors->tagihan_id = $errorMessage->tagihan_id[0];
                } else {
                    $detail->errors->tagihan_id = "ok";
                }
                if (isset($errorMessage->no_spm)) {
                    $detail->errors->no_spm = $errorMessage->no_spm[0];
                } else {
                    $detail->errors->no_spm = "ok";
                }
                if (isset($errorMessage->tanggal_spm)) {
                    $detail->errors->tanggal_spm = $errorMessage->tanggal_spm[0];
                } else {
                    $detail->errors->tanggal_spm = "ok";
                }
                if (isset($errorMessage->nomor_sp2d)) {
                    $detail->errors->nomor_sp2d = $errorMessage->nomor_sp2d[0];
                } else {
                    $detail->errors->nomor_sp2d = "ok";
                }
                if (isset($errorMessage->tanggal_sp2d)) {
                    $detail->errors->tanggal_sp2d = $errorMessage->tanggal_sp2d[0];
                } else {
                    $detail->errors->tanggal_sp2d = "ok";
                }
                $detail->row = $item[0];
                $detail->status = FALSE;
                $errors->push($detail);
            } else {
                $detail = (object) [];
                $detail->errors = (object) [];
                $detail->errors->tagihan_id = "ok";
                $detail->errors->no_spm = "ok";
                $detail->errors->tanggal_spm = "ok";
                $detail->errors->nomor_sp2d = "ok";
                $detail->errors->tanggal_sp2d = "ok";
                $detail->row = $item[0];
                $detail->status = TRUE;
                $errors->push($detail);
                tagihan::find($item[1])->update([
                    'tanggal_spm' => $item[5],
                    'nomor_sp2d' => $item[6],
                    'tanggal_sp2d' => $item[7],
                ]);
            }
        }

        if ($errors->min('status') === TRUE) {
            return redirect('/cleansing/spp')->with('berhasil', 'Data Berhasil Diuplaod');
        } else {
            return redirect('/cleansing/spp/import')->with('pesan', $errors->sum('status') . ' Data Berhasil Diupload Silakan Download Kembali Data SPP')->with('rowsErrors', collect($errors));
        }
    }
}
