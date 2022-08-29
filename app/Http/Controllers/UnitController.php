<?php

namespace App\Http\Controllers;

use App\Models\unit;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\StoreunitRequest;
use App\Http\Requests\UpdateunitRequest;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('referensi.unit.index',[
            'data'=>unit::orderby('kodeunit')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('referensi.unit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreunitRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kodeunit'=>'required|unique|min:2|max:2',
            'namaunit'=>'required'
        ]);

        $request->validate([
            'kodeunit'=>'numeric',
        ]);

        unit::create([
            'kodeunit'=>$request->kodeunit,
            'namaunit'=>$request->namaunit,
            'kodesatker'=>auth()->user()->satker,
        ]);

        return redirect('/unit');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(unit $unit)
    {
        //
    }

    public function showverifikator(unit $unit)
    {
        return view('referensi.unit.verifikator.index',[
            'data'=>$unit
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(unit $unit)
    {
        return view('referensi.unit.update',[
            'data'=>$unit
        ]);
    }

    public function editverifikator(unit $unit)
    {
        return view('referensi.unit.verifikator.create',[
            'data'=>User::where('satker', auth()->user()->satker)->verifikator()->verifikatornonsign($unit->id)->get(),
            'unit'=>$unit
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateunitRequest  $request
     * @param  \App\Models\unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, unit $unit)
    {
        $request->validate([
            'kodeunit'=>'required|unique|min:2|max:2',
            'kodeunit'=>'numeric',
            'namaunit'=>'required'
        ]);

        $unit->update([
            'kodeunit'=>$request->kodeunit,
            'namaunit'=>$request->namaunit,
        ]);

        return redirect('/unit');
    }

    public function updateverifikator(unit $unit, User $verifikator)
    {
        $unit->verifikator()->attach($verifikator->id);
        return redirect('/unit/'.$unit->id.'/verifikator/create')->with('berhasil', $verifikator->nama. ' Berhasil Ditambahkan Ke Unit '.$unit->namaunit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(unit $unit)
    {
        $unit->delete();
        return redirect('/unit');
    }

    public function destroyverifikator(unit $unit, User $verifikator)
    {
        $unit->verifikator()->detach($verifikator->id);
        return redirect('/unit/'.$unit->id.'/verifikator')->with('berhasil', $verifikator->nama. ' Berhasil Dihapus Dari Unit '.$unit->namaunit);
    }
}
