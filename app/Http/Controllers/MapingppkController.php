<?php

namespace App\Http\Controllers;

use App\Models\pagu;
use App\Models\User;
use App\Models\RefPPK;
use App\Models\RefStafPPK;
use App\Helper\Notification;
use App\Models\mapingpaguppk;
use App\Models\mapingstafppk;
use Illuminate\Support\Facades\Gate;

class MapingppkController extends Controller
{
    public function index()
    {
        if (!Gate::allows('admin_satker')) {
            abort(403);
        }
        return view('referensi.maping_ppk.index', [
            'data' => RefPPK::PPKsatker()->search()->orderBy('nip')->paginate(15)->withQueryString(),
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function showpagu(RefPPK $ppk)
    {
        if (!Gate::allows('admin_satker')) {
            abort(403);
        }

        if ($ppk->satker != auth()->user()->satker) {
            abort(403);
        }
        return view('referensi.maping_ppk.pagu.detail', [
            'data' => $ppk->paguppk()->with(['mapingppk'])->searchprogram()
                ->searchkegiatan()
                ->searchkro()
                ->searchro()
                ->searchkomponen()
                ->searchsubkomponen()
                ->searchakun()->paginate(15)->withQueryString(),
            'ppk' => $ppk,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function showstaf(RefPPK $ppk)
    {
        if (!Gate::allows('admin_satker')) {
            abort(403);
        }

        if ($ppk->satker != auth()->user()->satker) {
            abort(403);
        }

        return view('referensi.maping_ppk.staf.detail', [
            'data' => $ppk->stafppk()->search()->paginate(15)->withQueryString(),
            'ppk' => $ppk,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function editpagu(RefPPK $ppk)
    {
        if (!Gate::allows('admin_satker')) {
            abort(403);
        }

        if ($ppk->satker != auth()->user()->satker) {
            abort(403);
        }

        return view('referensi.maping_ppk.pagu.update', [
            'data' => pagu::with(['unit'])->where('kodesatker', auth()->user()->satker)->where('tahun', session()->get('tahun'))->Order()->pagunonppk()->searchprogram()
                ->searchkegiatan()
                ->searchkro()
                ->searchro()
                ->searchkomponen()
                ->searchsubkomponen()
                ->searchakun()->paginate(15)->withQueryString(),
            'ppk' => $ppk,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function editstaf(RefPPK $ppk)
    {
        if (!Gate::allows('admin_satker')) {
            abort(403);
        }

        if ($ppk->satker != auth()->user()->satker) {
            abort(403);
        }

        return view('referensi.maping_ppk.staf.update', [
            'data' => RefStafPPK::Satker()->notStaf($ppk->nip)->search()->paginate(15)->withQueryString(),
            'ppk' => $ppk,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function updatepagu(RefPPK $ppk, pagu $pagu)
    {
        if (!Gate::allows('admin_satker')) {
            abort(403);
        }

        if ($ppk->satker != auth()->user()->satker) {
            abort(403);
        }

        if ($ppk->satker != $pagu->kodesatker) {
            abort(403);
        }

        mapingpaguppk::create([
            'pagu_id' => $pagu->id,
            'user_id' => $ppk->nip
        ]);
        return Redirect()->back()->with('berhasil', 'Pagu Berhasil Ditambahkan Ke PPK ' . $ppk->nama);
        return redirect('/maping-ppk/' . $ppk->id . '/pagu/edit')->with('berhasil', 'Pagu Berhasil Ditambahkan Ke PPK ' . $ppk->nama);
    }

    public function updatestaf(RefPPK $ppk, RefStafPPK $staf)
    {
        if (!Gate::allows('admin_satker')) {
            abort(403);
        }

        if ($ppk->satker != auth()->user()->satker) {
            abort(403);
        }

        if ($ppk->satker != $staf->satker) {
            abort(403);
        }

        mapingstafppk::create([
            'staf_id' => $staf->nip,
            'ppk_id' => $ppk->nip
        ]);
        return redirect('/maping-ppk/' . $ppk->id . '/staf/edit')->with('berhasil', 'staf Berhasil Ditambahkan Ke PPK ' . $ppk->nama);
    }

    public function destroypagu(RefPPK $ppk, mapingpaguppk $mapingppk)
    {
        if (!Gate::allows('admin_satker')) {
            abort(403);
        }

        if ($ppk->satker != auth()->user()->satker) {
            abort(403);
        }

        $mapingppk->delete();
        return redirect('/maping-ppk/' . $ppk->id . '/pagu')->with('berhasil', 'Pagu Berhasil Di Hapus dari PPK');
    }

    public function destroystaf(RefPPK $ppk, mapingstafppk $mapingstafppk)
    {
        if (!Gate::allows('admin_satker')) {
            abort(403);
        }

        if ($ppk->satker != auth()->user()->satker) {
            abort(403);
        }

        $mapingstafppk->delete();
        return redirect('/maping-ppk/' . $ppk->id . '/staf')->with('berhasil', 'Pagu Berhasil Di Hapus dari PPK');
    }
}
