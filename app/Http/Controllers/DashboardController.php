<?php

namespace App\Http\Controllers;

use App\Models\pagu;
use App\Models\unit;
use App\Models\User;
use App\Models\realisasi;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index',[
            'belanjapegawai'=>pagu::pagusatker()->jenisbelanja('51'),
            'belanjabarang'=>pagu::pagusatker()->jenisbelanja('52'),
            'belanjamodal'=>pagu::pagusatker()->jenisbelanja('53'),
            'realisasibelanjapegawai'=>realisasi::sp2d()->realisaijenisbelanja('51'),
            'realisasibelanjabarang'=>realisasi::sp2d()->realisaijenisbelanja('52'),
            'realisasibelanjamodal'=>realisasi::sp2d()->realisaijenisbelanja('53'),
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
            'data'=>$unit->pagu()->order()->get(),
            'unit'=>$unit
        ]);
    }

    public function ppk_index()
    {
        return view('dashboard.ppk.index',[
            'ppk'=>User::pegawaisatker()->ppk()->whereHas('paguppk')->get(),
        ]);
    }

    public function ppk_detail(user $ppk)
    {
        return view('dashboard.ppk.detail',[
            'data'=>$ppk->paguppk()->order()->get(),
            'ppk'=>$ppk
        ]);
    }
}
