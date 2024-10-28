<?php

namespace App\Http\Controllers;

use App\Models\tagihan;
use App\Helper\Notification;
use Illuminate\Support\Facades\Gate;

class CleansingDuplikatController extends Controller
{
    public function index()
    {
        if (!Gate::any(['sys_admin', 'admin_satker'])) {
            abort(403);
        }
        return view('data_cleansing.duplikat.index', [
            'data' => tagihan::CleansingDuplikat()->paginate(15)->withQueryString(),
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function detail($jns, $nomor)
    {
        if (!Gate::any(['sys_admin', 'admin_satker'])) {
            abort(403);
        }
        return view('data_cleansing.duplikat.detail', [
            'data' => tagihan::CleansingDetailDuplikat($jns, $nomor)->with(['unit', 'ppk', 'dokumen', 'realisasi'])->paginate(15)->withQueryString(),
            'notifikasi'=>Notification::Notif()
        ]);
    }
}
