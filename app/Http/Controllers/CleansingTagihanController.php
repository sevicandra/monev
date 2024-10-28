<?php

namespace App\Http\Controllers;

use App\Models\dokumen;
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
            'data' => tagihan::Tagihansatker()->filter()->search()->order()->paginate(15)->withQueryString(),
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function edit(tagihan $tagihan)
    {
        if (! Gate::any(['sys_admin', 'admin_satker'])) {
            abort(403);
        }
        return view('data_cleansing.tagihan.update', [
            'data' => $tagihan,
            'dokumen' => dokumen::orderby('kodedokumen')->get(),
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function update(Request $request, tagihan $tagihan)
    {
        if (! Gate::any(['sys_admin', 'admin_satker'])) {
            abort(403);
        }
        $request->validate([
            'notagihan' => 'required|min:5|max:5',
            'tgltagihan' => 'required',
            'uraian' => 'required',
            'jnstagihan' => 'required',
            'kodedokumen' => 'required',
        ]);

        $request->validate([
            'notagihan' => 'numeric',
        ]);

        $tagihan->update([
            'notagihan' => $request->notagihan,
            'tgltagihan' => $request->tgltagihan,
            'uraian' => $request->uraian,
            'jnstagihan' => $request->jnstagihan,
            'kodedokumen' => $request->kodedokumen,
        ]);

        return redirect('/cleansing/tagihan')->with('success', 'Data Berhasil diperbarui');
    }
}
