<?php

namespace App\Http\Controllers;

use App\Models\tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CleansingTagihanController extends Controller
{
    public function index()
    {
        if (!Gate::any(['sys_admin', 'admin_satker'], auth()->user()->id)) {
            abort(403);
        }
        return view('data_cleansing.tagihan.index', [
            'data' => tagihan::CleansingTagihan()->paginate(15)->withQueryString()
        ]);
    }

    public function detail($jns, $nomor)
    {
        if (!Gate::any(['sys_admin', 'admin_satker'], auth()->user()->id)) {
            abort(403);
        }
        return view('data_cleansing.tagihan.detail', [
            'data' => tagihan::CleansingDetailTagihan($jns, $nomor)->paginate(15)->withQueryString()
        ]);
    }
}