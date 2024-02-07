<?php

namespace App\Http\Controllers;

use App\Models\unit;
use App\Models\User;
use App\Helper\Notification;
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
            'data'=>User::pegawaisatker()->stafppk()->search()->paginate(15)->withQueryString(),
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function showunit(User $stafppk)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($stafppk->satker != auth()->user()->satker){
            abort(403);
        }
        
        return view('referensi.maping_staf_ppk.unit.detail',[
            'data'=>$stafppk->unitstafppk()->search()->orderby('kodeunit')->paginate(15)->withQueryString(),
            'stafppk'=>$stafppk,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function editunit(User $stafppk)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($stafppk->satker != auth()->user()->satker){
            abort(403);
        }

        return view('referensi.maping_staf_ppk.unit.update',[
            'data'=>unit::Nostafppk($stafppk->nip)->search()->orderby('kodeunit')->paginate(15)->withQueryString(),
            'stafppk'=>$stafppk,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function updateunit(User $stafppk, unit $unit)
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

    public function destroyunit(User $stafppk, unit $unit)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        $stafppk->unitstafppk()->detach($unit->kodeunit);
        return redirect('/maping-staf-ppk/'.$stafppk->id.'/unit')->with('berhasil', 'Unit Berhasil Di Hapus dari Staf PPK');
    }
}
