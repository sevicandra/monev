<?php

namespace App\Http\Controllers;

use App\Models\unit;
use App\Models\User;
use App\Models\RefPPK;
use App\Models\RefStafPPK;
use App\Helper\Notification;
use App\Models\mapingstafppk;
use App\Models\mapingunitstafppk;
use Illuminate\Support\Facades\Gate;

class MapingstafppkController extends Controller
{
    public function index()
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        return view('referensi.maping_staf_ppk.index',[
            'data'=>RefStafPPK::satker()->search()->orderBy('nip')->paginate(15)->withQueryString(),
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function showunit(RefStafPPK $stafppk)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($stafppk->satker != auth()->user()->satker){
            abort(403);
        }
        
        return view('referensi.maping_staf_ppk.unit.detail',[
            'data'=>$stafppk->unit()->search()->orderby('kodeunit')->paginate(15)->withQueryString(),
            'stafppk'=>$stafppk,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function editunit(RefStafPPK $stafppk)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($stafppk->satker != auth()->user()->satker){
            abort(403);
        }

        return view('referensi.maping_staf_ppk.unit.update',[
            'data'=>unit::NotStaf($stafppk->nip)->search()->orderby('kodeunit')->paginate(15)->withQueryString(),
            'stafppk'=>$stafppk,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function updateunit(RefStafPPK $stafppk, unit $unit)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($stafppk->satker != $unit->kodesatker){
            abort(403);
        }

        mapingunitstafppk::create([
            'user_id'=>$stafppk->nip,
            'unit_id'=>$unit->kodeunit
        ]);
        return redirect('/maping-staf-ppk/'.$stafppk->id.'/unit/edit')->with('berhasil', 'Unit Berhasil Ditambahkan Ke Staf PPK '.$stafppk->nama);
    }

    public function destroyunit(RefStafPPK $stafppk, unit $unit)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        $stafppk->unit()->detach($unit->kodeunit);
        return redirect('/maping-staf-ppk/'.$stafppk->id.'/unit')->with('berhasil', 'Unit Berhasil Di Hapus dari Staf PPK');
    }

    public function showppk(RefStafPPK $stafppk)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($stafppk->satker != auth()->user()->satker){
            abort(403);
        }
        
        return view('referensi.maping_staf_ppk.ppk.detail',[
            'data'=>$stafppk->ppk()->search()->orderby('nip')->paginate(15)->withQueryString(),
            'stafppk'=>$stafppk,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function editppk(RefStafPPK $stafppk)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($stafppk->satker != auth()->user()->satker){
            abort(403);
        }

        return view('referensi.maping_staf_ppk.ppk.update',[
            'data'=>RefPPK::NotPPK($stafppk->nip)->search()->orderby('nip')->paginate(15)->withQueryString(),
            'stafppk'=>$stafppk,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function updateppk(RefStafPPK $stafppk, RefPPK $ppk)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($stafppk->satker != $ppk->satker){
            abort(403);
        }

        mapingstafppk::create([
            'staf_id'=>$stafppk->nip,
            'ppk_id'=>$ppk->nip
        ]);
        return redirect('/maping-staf-ppk/'.$stafppk->id.'/ppk/edit')->with('berhasil', 'PPK Berhasil Ditambahkan Ke Staf PPK '.$stafppk->nama);
    }

    public function destroyppk(RefStafPPK $stafppk, RefPPK $ppk)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        $stafppk->ppk()->detach($ppk->nip);
        return redirect('/maping-staf-ppk/'.$stafppk->id.'/ppk')->with('berhasil', 'PPK Berhasil Di Hapus dari Staf PPK');
    }
}
