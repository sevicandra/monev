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
            'ppk'=>User::pegawaisatker()->ppk()->get(),
            'unit'=>unit::myunit()->whereHas('pagu')->get(),
        ]);
    }
}
