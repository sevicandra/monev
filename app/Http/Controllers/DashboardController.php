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
        return view('dashboard.index',[
            'belanjapegawai'=>pagu::pagusatker()->jenisbelanja('51')->get(),
            'belanjabarang'=>pagu::pagusatker()->jenisbelanja('52')->get(),
            'belanjamodal'=>pagu::pagusatker()->jenisbelanja('53')->get(),
            'realisasibelanjapegawai'=>realisasi::sp2d()->realisaijenisbelanja('51')->get(),
            'realisasibelanjabarang'=>realisasi::sp2d()->realisaijenisbelanja('52')->get(),
            'realisasibelanjamodal'=>realisasi::sp2d()->realisaijenisbelanja('53')->get(),
            'ppk'=>RefPPK::PPKsatker()->whereHas('paguppk')->get(),
            'unit'=>unit::myunit()->whereHas('pagu')->get(),
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function unit_index()
    {
        return view('dashboard.unit.index',[
            'unit'=>unit::myunit()->whereHas('pagu')->get(),
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function unit_detail(unit $unit)
    {
        return view('dashboard.unit.detail',[
            'data'=>tagihan::realisasiBulananUnit($unit)->orderBy('bulan')->get(),
            'unit'=>$unit,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function unit_detail_bulan(unit $unit, $bulan)
    {
        $bulanModel= bulan::where('kodebulan', $bulan)->first();
        return view('dashboard.unit.detail-pok',[
            'data'=>pagu::RealisasiBulananUnit($unit, $bulanModel->kodebulan)->orderBy('pok')->get(),
            'unit'=>$unit,
            'bulan'=>$bulanModel,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function unit_detail_tagihan(unit $unit, $bulan)
    {
        if ($bulan === 'null') {
            $bulanModel=new bulan();
            $bulanModel->bulan = null;
            $bulanModel->namabulan = null;
        }else{
            $bulanModel= bulan::where('kodebulan', $bulan)->first();
        }
        return view('dashboard.unit.detail-tagihan',[
            'data'=> tagihan::realisasiTagihanPerBulanUnit($unit, $bulan)->get(),
            'unit'=>$unit,
            'bulan'=>$bulanModel,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function ppk_index()
    {
        return view('dashboard.ppk.index',[
            'ppk'=>RefPPK::PPKsatker()->whereHas('paguppk')->get(),
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function ppk_detail(RefPPK $ppk)
    {
        return view('dashboard.ppk.detail',[
            'data'=>tagihan::realisasiBulananPpk($ppk->nip)->orderBy('bulan')->get(),
            'ppk'=>$ppk,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function ppk_detail_bulan(RefPPK $ppk, $bulan)
    {
        $bulanModel= bulan::where('kodebulan', $bulan)->first();
        return view('dashboard.ppk.detail-pok',[
            'data'=>pagu::RealisasiBulananPpk($ppk->nip, $bulanModel->kodebulan)->orderBy('pok')->get(),
            'ppk'=>$ppk,
            'bulan'=>$bulanModel,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function ppk_detail_tagihan(RefPPK $ppk, $bulan)
    {
        if ($bulan === 'null') {
            $bulanModel=new bulan();
            $bulanModel->bulan = null;
            $bulanModel->namabulan = null;
        }else{
            $bulanModel= bulan::where('kodebulan', $bulan)->first();
        }

        return view('dashboard.ppk.detail-tagihan',[
            'data'=> tagihan::realisasiTagihanPerBulanPpk($ppk->nip, $bulan)->get(),
            'ppk'=>$ppk,
            'bulan'=>$bulanModel,
            'notifikasi'=>Notification::Notif()
        ]);
    }
}
