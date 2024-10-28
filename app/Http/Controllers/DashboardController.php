<?php

namespace App\Http\Controllers;

use App\Models\pagu;
use App\Models\unit;
use App\Models\bulan;
use App\Models\RefPPK;
use App\Models\tagihan;
use App\Models\realisasi;
use App\Helper\Notification;

class DashboardController extends Controller
{
    public function index()
    {
        $pagusatker = pagu::Pagusatker()->selectRaw('left(akun, 2) as jenisbelanja, sum(anggaran) as total_anggaran')->groupBy('jenisbelanja')->get();
        return view('dashboard.index', [
            'belanjapegawai' => $pagusatker->where('jenisbelanja', '51'),
            'belanjabarang' => $pagusatker->where('jenisbelanja', '52'),
            'belanjamodal' => $pagusatker->where('jenisbelanja', '53'),
            'realisasibelanjapegawai' => realisasi::sp2d()->realisaijenisbelanja('51')->get(),
            'realisasibelanjabarang' => realisasi::sp2d()->realisaijenisbelanja('52')->get(),
            'realisasibelanjamodal' => realisasi::sp2d()->realisaijenisbelanja('53')->get(),
            'ppk' => RefPPK::with(['paguppk' => ['realisasi.tagihan.spm', 'sspb.tagihan.spm']])->PPKsatker()->whereHas('paguppk')->get(),
            'unit' => unit::myunit()->with(['pagu' => ['realisasi.tagihan.spm', 'sspb.tagihan.spm']])->whereHas('pagu')->get(),
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function unit_index()
    {
        return view('dashboard.unit.index', [
            'unit' => unit::myunit()->with(['pagu' => ['realisasi.tagihan.spm', 'sspb.tagihan.spm']])->whereHas('pagu')->get(),
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function unit_detail(unit $unit)
    {
        return view('dashboard.unit.detail', [
            'data' => tagihan::realisasiBulananUnit($unit)->orderBy('bulan')->get()->mapToGroups(function ($item) {
                return (object) [
                    $item->bulan  => (object) [
                        'bulan' => $item->bulan,
                        'namabulan' => $item->namabulan,
                        'realisasi' => $item->realisasi->sum('realisasi'),
                        'sspb' => $item->sspb->sum('nominal_sspb'),
                    ]
                ];
            })->map(function ($item) {
                return (object)[
                    'bulan' => $item->first()->bulan,
                    'namabulan' => $item->first()->namabulan,
                    'total_realisasi' => $item->sum('realisasi'),
                    'total_sspb' => $item->sum('sspb')
                ];
            }),
            'unit' => $unit,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function unit_detail_bulan(unit $unit, $bulan)
    {
        $bulanModel = bulan::where('kodebulan', $bulan)->first();
        return view('dashboard.unit.detail-pok', [
            'data' => pagu::RealisasiBulananUnit($unit, $bulanModel->kodebulan)->orderBy('pok')->get(),
            'unit' => $unit,
            'bulan' => $bulanModel,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function unit_detail_tagihan(unit $unit, $bulan)
    {
        if ($bulan === 'null') {
            $bulanModel = new bulan();
            $bulanModel->bulan = null;
            $bulanModel->namabulan = null;
        } else {
            $bulanModel = bulan::where('kodebulan', $bulan)->first();
        }
        return view('dashboard.unit.detail-tagihan', [
            'data' => tagihan::realisasiTagihanPerBulanUnit($unit, $bulan)->filter()->order()->get(),
            'unit' => $unit,
            'bulan' => $bulanModel,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function ppk_index()
    {
        return view('dashboard.ppk.index', [
            'ppk' => RefPPK::with(['paguppk', 'paguppk.realisasi.tagihan.spm', 'paguppk.sspb.tagihan.spm'])->PPKsatker()->whereHas('paguppk')->get(),
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function ppk_detail(RefPPK $ppk)
    {
        return view('dashboard.ppk.detail', [
            'data' => tagihan::realisasiBulananPpk($ppk->nip)->orderBy('bulan')->get()->mapToGroups(function ($item) {
                return (object) [
                    $item->bulan  => (object) [
                        'bulan' => $item->bulan,
                        'namabulan' => $item->namabulan,
                        'realisasi' => $item->realisasi->sum('realisasi'),
                        'sspb' => $item->sspb->sum('nominal_sspb'),
                    ]
                ];
            })->map(function ($item) {
                return (object)[
                    'bulan' => $item->first()->bulan,
                    'namabulan' => $item->first()->namabulan,
                    'total_realisasi' => $item->sum('realisasi'),
                    'total_sspb' => $item->sum('sspb')
                ];
            }),
            'ppk' => $ppk,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function ppk_detail_bulan(RefPPK $ppk, $bulan)
    {
        $bulanModel = bulan::where('kodebulan', $bulan)->first();
        return view('dashboard.ppk.detail-pok', [
            'data' => pagu::RealisasiBulananPpk($ppk->nip, $bulanModel->kodebulan)->orderBy('pok')->get(),
            'ppk' => $ppk,
            'bulan' => $bulanModel,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function ppk_detail_tagihan(RefPPK $ppk, $bulan)
    {
        if ($bulan === 'null') {
            $bulanModel = new bulan();
            $bulanModel->bulan = null;
            $bulanModel->namabulan = null;
        } else {
            $bulanModel = bulan::where('kodebulan', $bulan)->first();
        }

        return view('dashboard.ppk.detail-tagihan', [
            'data' => tagihan::realisasiTagihanPerBulanPpk($ppk->nip, $bulan)->filter()->order()->get(),
            'ppk' => $ppk,
            'bulan' => $bulanModel,
            'notifikasi' => Notification::Notif()
        ]);
    }
}
