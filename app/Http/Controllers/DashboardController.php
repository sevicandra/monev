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
        $pagusatker = pagu::Pagusatker()->selectRaw('pagus.*, left(akun, 2) as jenisbelanja')->get()->groupBy('jenisbelanja');
        return view('dashboard.index', [
            'belanjapegawai' => $pagusatker['51'],
            'belanjabarang' => $pagusatker['52'],
            'belanjamodal' => $pagusatker['53'],
            'realisasibelanjapegawai' => realisasi::sp2d()->realisaijenisbelanja('51')->get(),
            'realisasibelanjabarang' => realisasi::sp2d()->realisaijenisbelanja('52')->get(),
            'realisasibelanjamodal' => realisasi::sp2d()->realisaijenisbelanja('53')->get(),
            'ppk' => RefPPK::with(['paguppk'=>['realisasi.tagihan', 'sspb.tagihan']])->PPKsatker()->whereHas('paguppk')->get(),
            'unit' => unit::myunit()->with(['pagu'=>['realisasi.tagihan', 'sspb.tagihan']])->whereHas('pagu')->get(),
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function unit_index()
    {
        // return unit::myunit()->with(['pagu'=> ['realisasi.tagihan', 'sspb.tagihan']])->whereHas('pagu')->first()->pagu;
        return view('dashboard.unit.index', [
            'unit' => unit::myunit()->with(['pagu'=> ['realisasi.tagihan', 'sspb.tagihan']])->whereHas('pagu')->get(),
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function unit_detail(unit $unit)
    {
        return tagihan::realisasiBulananUnit($unit)->orderBy('bulan')->get();
        return view('dashboard.unit.detail', [
            'data' => tagihan::realisasiBulananUnit($unit)->orderBy('bulan')->get(),
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
            'data' => tagihan::realisasiTagihanPerBulanUnit($unit, $bulan)->get(),
            'unit' => $unit,
            'bulan' => $bulanModel,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function ppk_index()
    {
        return view('dashboard.ppk.index', [
            'ppk' => RefPPK::with(['paguppk', 'paguppk.realisasi.tagihan', 'paguppk.sspb.tagihan'])->PPKsatker()->whereHas('paguppk')->get(),
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function ppk_detail(RefPPK $ppk)
    {
        return view('dashboard.ppk.detail', [
            'data' => tagihan::realisasiBulananPpk($ppk->nip)->orderBy('bulan')->get(),
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
            'data' => tagihan::realisasiTagihanPerBulanPpk($ppk->nip, $bulan)->get(),
            'ppk' => $ppk,
            'bulan' => $bulanModel,
            'notifikasi' => Notification::Notif()
        ]);
    }
}
