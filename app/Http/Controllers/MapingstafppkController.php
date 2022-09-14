<?php

namespace App\Http\Controllers;

use App\Models\unit;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\mapingunitstafppk;
use Illuminate\Support\Facades\Gate;

class MapingstafppkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        return view('referensi.maping_staf_ppk.index',[
            'data'=>User::pegawaisatker()->stafppk()->search()->paginate(15)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
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
            'stafppk'=>$stafppk
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
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
            'stafppk'=>$stafppk
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function updateunit(User $stafppk, unit $unit)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($stafppk->satker != $unit->kodesatker){
            abort(403);
        }

        mapingunitstafppk::create([
            'user_id'=>$stafppk->id,
            'unit_id'=>$unit->id
        ]);
        return redirect('/maping-staf-ppk/'.$stafppk->id.'/unit/edit')->with('berhasil', 'Unit Berhasil Ditambahkan Ke Staf PPK '.$stafppk->nama);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroyunit(User $stafppk, unit $unit)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        $stafppk->unitstafppk()->detach($unit->id);
        return redirect('/maping-staf-ppk/'.$stafppk->id.'/unit')->with('berhasil', 'Unit Berhasil Di Hapus dari Staf PPK');
    }
}
