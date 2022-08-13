<?php

namespace App\Http\Controllers;

use App\Models\unit;
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
        return view('unit.index',[
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
        return view('unit.create');
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function edit(unit $unit)
    {
        return view('unit.update',[
            'data'=>$unit
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
}
