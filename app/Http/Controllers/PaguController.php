<?php

namespace App\Http\Controllers;

use App\Models\pagu;
use App\Models\unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StorepaguRequest;
use App\Http\Requests\UpdatepaguRequest;

class PaguController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::any(['KPA', 'Staf_KPA'], auth()->user()->id)) {
            abort(403);
        }

        return view('pagu.index',[
            'data'=>pagu::Order()->where('kodesatker', auth()->user()->satker)->where('tahun', session()->get('tahun')) ->searchprogram()  
                                                                                                                        ->searchkegiatan()
                                                                                                                        ->searchkro()
                                                                                                                        ->searchro()
                                                                                                                        ->searchkomponen()
                                                                                                                        ->searchsubkomponen()
                                                                                                                        ->searchakun()->paginate(15)->withQueryString()
            
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::any(['KPA', 'Staf_KPA'], auth()->user()->id)) {
            abort(403);
        }

        return view('pagu.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorepaguRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::any(['KPA', 'Staf_KPA'], auth()->user()->id)) {
            abort(403);
        }

        $request->validate([
            'program'=>'required|min:2|max:2',
            'kegiatan'=>'required|min:4|max:4',
            'kro'=>'required|min:3|max:3',
            'ro'=>'required|min:3|max:3',
            'komponen'=>'required|min:3|max:3',
            'subkomponen'=>'required|min:1|max:1',
            'akun'=>'required|min:6|max:6',
            'anggaran'=>'required|numeric',
        ]);

        $request->validate([
            'kegiatan'=>'numeric',
            'ro'=>'numeric',
            'komponen'=>'numeric',
            'akun'=>'numeric',
        ]);

        pagu::create([
            'program'=>$request->program,
            'kegiatan'=>$request->kegiatan,
            'kro'=>$request->kro,
            'ro'=>$request->ro,
            'komponen'=>$request->komponen,
            'subkomponen'=>$request->subkomponen,
            'akun'=>$request->akun,
            'anggaran'=>$request->anggaran,
            'tahun'=>session()->get('tahun'),
            'kodesatker'=>auth()->user()->satker,
        ]);

        return redirect('/pagu');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pagu  $pagu
     * @return \Illuminate\Http\Response
     */
    public function show(pagu $pagu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pagu  $pagu
     * @return \Illuminate\Http\Response
     */
    public function edit(pagu $pagu)
    {
        if (! Gate::any(['KPA', 'Staf_KPA'], auth()->user()->id)) {
            abort(403);
        }

        return view('pagu.update',[
            'unit'=>unit::where('kodesatker', auth()->user()->satker)->orderby('kodeunit')->get(),
            'data'=>$pagu
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepaguRequest  $request
     * @param  \App\Models\pagu  $pagu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pagu $pagu)
    {
        if (! Gate::any(['KPA', 'Staf_KPA'], auth()->user()->id)) {
            abort(403);
        }

        $request->validate([
            'program'=>'required|min:2|max:2',
            'kegiatan'=>'required|min:4|max:4',
            'kro'=>'required|min:3|max:3',
            'ro'=>'required|min:3|max:3',
            'komponen'=>'required|min:3|max:3',
            'subkomponen'=>'required|min:1|max:1',
            'akun'=>'required|min:6|max:6',
            'anggaran'=>'required|numeric',
            'kodeunit'=>'required'
        ]);

        $request->validate([
            'kegiatan'=>'numeric',
            'ro'=>'numeric',
            'komponen'=>'numeric',
            'akun'=>'numeric',
        ]);

        $pagu->update([
            'program'=>$request->program,
            'kegiatan'=>$request->kegiatan,
            'kro'=>$request->kro,
            'ro'=>$request->ro,
            'komponen'=>$request->komponen,
            'subkomponen'=>$request->subkomponen,
            'akun'=>$request->akun,
            'program'=>$request->program,
            'anggaran'=>$request->anggaran,
            'kodeunit'=>$request->kodeunit
        ]);

        return redirect('/pagu');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pagu  $pagu
     * @return \Illuminate\Http\Response
     */
    public function destroy(pagu $pagu)
    {
        if (! Gate::any(['KPA', 'Staf_KPA'], auth()->user()->id)) {
            abort(403);
        }

        $pagu->delete();
        return redirect('/pagu');
    }

    public function import(Request $request)
    {
        if (! Gate::any(['KPA', 'Staf_KPA'], auth()->user()->id)) {
            abort(403);
        }
        
        if ($request->all()) {
            $file_mimes = array('application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            
            $file = $request->file('berkas_excel');
            $extension = $file->extension(); // Determine the file's extension based on the file's MIME type...

            if ('csv' == $extension) {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Csv();
            } else {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            }
            $spreadsheet = $reader->load($file);
            $spreadsheet->getActiveSheet()->setCellValueByColumnAndRow(1,1, '=counta(C1:C1000)');
            $sheetData = $spreadsheet->getSheetByName('pagu')->toArray();
            
            for ($i=7; $i < 507 ; $i++) { 
                if ($sheetData[$i][2] === null || $sheetData[$i][3] === null || $sheetData[$i][4] === null || $sheetData[$i][5] === null || $sheetData[$i][6] === null || $sheetData[$i][7] === null || $sheetData[$i][8] === null || $sheetData[$i][9] === null) {
                    break;
                }
                pagu::create([
                    'program'=>$sheetData[$i][2],
                    'kegiatan'=>$sheetData[$i][3],
                    'kro'=>$sheetData[$i][4],
                    'ro'=>$sheetData[$i][5],
                    'komponen'=>$sheetData[$i][6],
                    'subkomponen'=>$sheetData[$i][7],
                    'akun'=>$sheetData[$i][8],
                    'anggaran'=>$sheetData[$i][9],
                    'tahun'=>session()->get('tahun'),
                    'kodesatker'=>auth()->user()->satker,
                    'kodeunit'=>$sheetData[$i][10],
                ]);
                
            }
            return redirect('/pagu');      
        }

        return view('pagu.import');
    }

    public function template()
    {
        return response()->download(file: 'xlsx/upload_pagu.xlsx');
    }
}
