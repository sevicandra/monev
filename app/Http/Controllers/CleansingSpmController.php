<?php

namespace App\Http\Controllers;

use App\Models\spm;
use App\Models\tagihan;
use App\Helper\Notification;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class CleansingSpmController extends Controller
{
    public function index()
    {
        if (!Gate::any(['sys_admin', 'admin_satker'])) {
            abort(403);
        }
        return view('data_cleansing.SPM.index', [
            'data' => spm::with('realisasi')->where('kd_satker', session()->get('kdsatker'))
                ->search()
                ->where('tahun', session()->get('tahun'))
                ->order()
                ->paginate(15)->withQueryString(),
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function load()
    {
        if (!Gate::any(['sys_admin', 'admin_satker'])) {
            abort(403);
        }
        $data = tagihan::where('tahun', session()->get('tahun'))->orderBy('no_spm')->get();
        foreach ($data as $item) {
            if ($item->tanggal_spm == null || $item->tanggal_sp2d == null || $item->nomor_sp2d == null || $item->no_spm == null) {
                continue;
            }
            $spm = spm::updateOrCreate([
                'nomor_sp2d' => $item->nomor_sp2d,
            ], [
                'nomor_spm' => $item->no_spm,
                'tahun' => session()->get('tahun'),
                'tanggal_spm' => $item->tanggal_spm,
                'tanggal_sp2d' => $item->tanggal_sp2d,
                'kd_satker' => session()->get('kdsatker'),
            ]);

            $item->where('id', $item->id)->update([
                'spm_id' => $spm->id
            ]);
        }

        return redirect()->back()->with('success', 'Data SPM Berhasil disimpan');
    }

    public function edit(spm $spm)
    {
        if (!Gate::any(['sys_admin', 'admin_satker'])) {
            abort(403);
        }
        if ($spm->kd_satker != auth()->user()->satker) {
            abort(404);
        }

        return view('data_cleansing.SPM.edit', [
            'data' => $spm,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function update(spm $spm, Request $request)
    {
        if (!Gate::any(['sys_admin', 'admin_satker'])) {
            abort(403);
        }

        if ($spm->kd_satker != auth()->user()->satker) {
            abort(403);
        }

        $request->validate([
            'nomor_spm' => 'required|digits:6|unique:spms,nomor_spm,' . $spm->id,
            'tanggal_spm' => 'required',
            'nomor_sp2d' => 'required|digits:15|unique:spms,nomor_sp2d,' . $spm->id,
            'tanggal_sp2d' => 'required',
            'deskripsi' => 'required',
            'jenis_spm' => 'required',
        ]);


        $spm->update([
            'nomor_spm' => $request->nomor_spm,
            'tanggal_spm' => $request->tanggal_spm,
            'nomor_sp2d' => $request->nomor_sp2d,
            'tanggal_sp2d' => $request->tanggal_sp2d,
            'deskripsi' => $request->deskripsi,
            'jenis_spm' => $request->jenis_spm,
        ]);
        return redirect()->route('spm.index')->with('berhasil', 'Data SPM Berhasil diubah');
    }

    public function detail(spm $spm)
    {
        if (!Gate::any(['sys_admin', 'admin_satker'])) {
            abort(403);
        }
        return view('data_cleansing.SPM.detail', [
            'data' => $spm->tagihan()->with(['realisasi', 'unit', 'dokumen', 'ppk'])->filter()->search()->order()->paginate(15)->withQueryString(),
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function detachSPM(spm $spm, tagihan $tagihan)
    {
        if (!Gate::any(['sys_admin', 'admin_satker'])) {
            abort(403);
        }

        if ($spm->kd_satker != auth()->user()->satker) {
            abort(403);
        }

        $spm->tagihan()->find($tagihan->id)->update([
            'spm_id' => null
        ]);

        return redirect()->back()->with('berhasil', 'Data SPM Berhasil dihapus');
    }

    public function import()
    {
        if (!Gate::any(['sys_admin', 'admin_satker'])) {
            abort(403);
        }
        return view('data_cleansing.SPM.import', [
            'notifikasi' => Notification::Notif(),
        ]);
    }

    public function importStore(Request $request)
    {
        if (!Gate::any(['sys_admin', 'admin_satker'])) {
            abort(403);
        }
        $file = $request->file('file');
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load($file);
        $sheetData = $spreadsheet->getActiveSheet()->rangeToArray("B4:N" . $spreadsheet->getActiveSheet()->getHighestRow());
        foreach ($sheetData as $item) {
            if ($item[0] == null) {
                continue;
            }
            spm::updateOrCreate(
                [
                    'nomor_sp2d' => $item[0] + 0,
                ],
                [
                    'nomor_spm' => substr($item[9], 0, 6),
                    'tanggal_spm' => Carbon::parse($item[10])->format('Y-m-d'),
                    'tanggal_sp2d' => Carbon::parse($item[2])->format('Y-m-d'),
                    'jenis_spm' => $item[8],
                    'deskripsi' => $item[12],
                    'tahun' => session()->get('tahun'),
                    'kd_satker' => session()->get('kdsatker'),
                ]
            );
        }
        return redirect('/cleansing/spm')->with('berhasil', 'Data SPM Berhasil diimport');
    }
}
