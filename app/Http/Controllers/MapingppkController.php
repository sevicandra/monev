<?php

namespace App\Http\Controllers;

use App\Models\pagu;
use App\Models\User;
use App\Models\mapingpaguppk;
use App\Models\mapingstafppk;
use Illuminate\Support\Facades\Gate;

class MapingppkController extends Controller
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

        return view('referensi.maping_ppk.index',[
            'data'=>User::pegawaisatker()->ppk()->get()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\mapingpaguppk  $mapingpaguppk
     * @return \Illuminate\Http\Response
     */
    public function showpagu(User $ppk)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($ppk->satker != auth()->user()->satker){
            abort(403);
        }

        return view('referensi.maping_ppk.pagu.detail',[
            'data'=>$ppk->paguppk,
            'ppk'=>$ppk
        ]);
    }

    public function showstaf(User $ppk)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($ppk->satker != auth()->user()->satker){
            abort(403);
        }

        return view('referensi.maping_ppk.staf.detail',[
            'data'=>$ppk->stafppk,
            'ppk'=>$ppk
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\mapingpaguppk  $mapingpaguppk
     * @return \Illuminate\Http\Response
     */
    public function editpagu(User $ppk)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($ppk->satker != auth()->user()->satker){
            abort(403);
        }

        return view('referensi.maping_ppk.pagu.update',[
            'data'=>pagu::pagunonppk()->get(),
            'ppk'=>$ppk
        ]);
    }

    public function editstaf(User $ppk)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($ppk->satker != auth()->user()->satker){
            abort(403);
        }

        return view('referensi.maping_ppk.staf.update',[
            'data'=>User::stafnoppk()->get(),
            'ppk'=>$ppk
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatemapingpaguppkRequest  $request
     * @param  \App\Models\mapingpaguppk  $mapingpaguppk
     * @return \Illuminate\Http\Response
     */
    public function updatepagu(User $ppk, pagu $pagu)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($ppk->satker != auth()->user()->satker){
            abort(403);
        }

        if($ppk->satker != $pagu->kodesatker){
            abort(403);
        }

        mapingpaguppk::create([
            'pagu_id'=>$pagu->id,
            'user_id'=>$ppk->id
        ]);
        return redirect('/maping-ppk/'.$ppk->id.'/pagu/edit')->with('berhasil', 'Pagu Berhasil Ditambahkan Ke PPK '.$ppk->nama);
    }

    public function updatestaf(User $ppk, User $staf)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($ppk->satker != auth()->user()->satker){
            abort(403);
        }

        if($ppk->satker != $staf->satker){
            abort(403);
        }

        mapingstafppk::create([
            'staf_id'=>$staf->id,
            'ppk_id'=>$ppk->id
        ]);
        return redirect('/maping-ppk/'.$ppk->id.'/staf/edit')->with('berhasil', 'staf Berhasil Ditambahkan Ke PPK '.$ppk->nama);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\mapingpaguppk  $mapingpaguppk
     * @return \Illuminate\Http\Response
     */
    public function destroypagu(User $ppk, mapingpaguppk $mapingppk)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($ppk->satker != auth()->user()->satker){
            abort(403);
        }

        $mapingppk->delete();
        return redirect('/maping-ppk/'.$ppk->id.'/pagu')->with('berhasil', 'Pagu Berhasil Di Hapus dari PPK');
    }

    public function destroystaf(User $ppk, mapingstafppk $mapingstafppk)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($ppk->satker != auth()->user()->satker){
            abort(403);
        }

        $mapingstafppk->delete();
        return redirect('/maping-ppk/'.$ppk->id.'/staf')->with('berhasil', 'Pagu Berhasil Di Hapus dari PPK');
    }
}
