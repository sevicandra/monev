<?php

namespace App\Http\Controllers;

use App\Models\tagihan;
use App\Helper\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CleansingTagihanController extends Controller
{
    public function index()
    {
        if (!Gate::any(['sys_admin', 'admin_satker'])) {
            abort(403);
        }
        return view('data_cleansing.tagihan.index', [
            'data' => tagihan::CleansingTagihan()->paginate(15)->withQueryString(),
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function detail($jns, $nomor)
    {
        if (!Gate::any(['sys_admin', 'admin_satker'])) {
            abort(403);
        }
        return view('data_cleansing.tagihan.detail', [
            'data' => tagihan::CleansingDetailTagihan($jns, $nomor)->with(['unit', 'ppk', 'dokumen', 'realisasi'])->paginate(15)->withQueryString(),
            'notifikasi'=>Notification::Notif()
        ]);
    }
}
