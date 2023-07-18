<?php

namespace App\Http\Controllers;

use App\Models\pagu;
use App\Models\unit;
use App\Models\User;
use App\Models\bulan;
use App\Models\tagihan;
use App\Models\realisasi;

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
            'ppk'=>User::pegawaisatker()->ppk()->whereHas('paguppk')->get(),
            'unit'=>unit::myunit()->whereHas('pagu')->get(),
        ]);
    }

    public function unit_index()
    {
        return view('dashboard.unit.index',[
            'unit'=>unit::myunit()->whereHas('pagu')->get(),
        ]);
    }

    public function unit_detail(unit $unit)
    {
        return view('dashboard.unit.detail',[
            'data'=>tagihan::realisasiBulananUnit($unit)->orderBy('bulan')->get(),
            'unit'=>$unit
        ]);
    }

    public function unit_detail_bulan(unit $unit, $bulan)
    {
        $bulanModel= bulan::where('kodebulan', $bulan)->first();
        return view('dashboard.unit.detail-pok',[
            'data'=>pagu::RealisasiBulananUnit($unit, $bulanModel->kodebulan)->orderBy('pok')->get(),
            'unit'=>$unit,
            'bulan'=>$bulanModel
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
            'bulan'=>$bulanModel
        ]);
    }

    public function ppk_index()
    {
        return view('dashboard.ppk.index',[
            'ppk'=>User::pegawaisatker()->ppk()->whereHas('paguppk')->get(),
        ]);
    }

    public function ppk_detail(User $ppk)
    {
        return view('dashboard.ppk.detail',[
            'data'=>tagihan::realisasiBulananPpk($ppk->id)->orderBy('bulan')->get(),
            'ppk'=>$ppk
        ]);
    }

    public function ppk_detail_bulan(User $ppk, $bulan)
    {
        $bulanModel= bulan::where('kodebulan', $bulan)->first();
        return view('dashboard.ppk.detail-pok',[
            'data'=>pagu::RealisasiBulananPpk($ppk->id, $bulanModel->kodebulan)->orderBy('pok')->get(),
            'ppk'=>$ppk,
            'bulan'=>$bulanModel
        ]);
    }

    public function ppk_detail_tagihan(User $ppk, $bulan)
    {
        if ($bulan === 'null') {
            $bulanModel=new bulan();
            $bulanModel->bulan = null;
            $bulanModel->namabulan = null;
        }else{
            $bulanModel= bulan::where('kodebulan', $bulan)->first();
        }

        return view('dashboard.ppk.detail-tagihan',[
            'data'=> tagihan::realisasiTagihanPerBulanPpk($ppk->id, $bulan)->get(),
            'ppk'=>$ppk,
            'bulan'=>$bulanModel
        ]);
    }
}
