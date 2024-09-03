<?php

namespace App\Http\Controllers;

use App\Models\pagu;

class RekapSPMController extends Controller
{
    public function index()
    {
        $data = pagu::paguSatker()->RekapSPM()->get();
        $array = [];
        foreach ($data->groupBy('program') as $program) {
            foreach ($program->groupBy('kegiatan') as $kegiatan) {
                foreach ($kegiatan->groupBy('kro') as $kro) {
                    $total = 0;
                    foreach ($kro as $item) {
                        $total += $item->realisasi->sum('realisasi');
                    }
                    $array[] = [
                        'program' => $program->first()->program,
                        'kegiatan' => $kegiatan->first()->kegiatan,
                        'kro' => $kro->first()->kro,
                        'total' => $total
                    ];
                }
            }
        }
        return view('data_cleansing.rekap_spm.index', [
            'data' => collect($array)
        ]);
    }
    public function show($program, $kegiatan, $kro)
    {
        $data = pagu::paguSatker()->RekapSPM($program, $kegiatan, $kro)->get();
        $array = [];
        foreach ($data->groupBy('akun') as $akun) {
            $total = 0;
            foreach ($akun as $item) {
                $total += $item->realisasi->sum('realisasi');
            }
            $array[] = [
                'akun' => $akun->first()->akun,
                'program' => $akun->first()->program,
                'kegiatan' => $akun->first()->kegiatan,
                'kro' => $akun->first()->kro,
                'total' => $total
            ];
        }
        return view('data_cleansing.rekap_spm.show', [
            'data' => collect($array)
        ]);
    }
    public function detail($program, $kegiatan, $kro, $akun)
    {
        $data = pagu::paguSatker()->RekapSPM($program, $kegiatan, $kro, $akun)->get();
        $array = [];
        foreach ($data as $item) {
            foreach ($item->realisasi as $realisasi) {
                $array[] = [
                    "no_spm" => $realisasi->tagihan->no_spm,
                    "tanggal_spm" => $realisasi->tagihan->tanggal_spm,
                    "nomor_sp2d" => $realisasi->tagihan->nomor_sp2d,
                    "tanggal_sp2d" => $realisasi->tagihan->tanggal_sp2d,
                    "nominal" => $realisasi->realisasi
                ];
            }
        }
        return view('data_cleansing.rekap_spm.detail', [
            'data' => collect($array)
        ]);
    }
}
