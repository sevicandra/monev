<?php

namespace App\Http\Controllers;

use App\Models\berkas;
use App\Http\Requests\StoreberkasRequest;
use App\Http\Requests\UpdateberkasRequest;
use Illuminate\Http\Request;

class BerkasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('berkas.index',[
            'data'=>berkas::orderby('kodeberkas')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('berkas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreberkasRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'kode'=>'required|unique|min:2|max:2',
            'kode'=>'numeric',
            'berkas'=>'required|'
        ]);

        berkas::create([
            'kodeberkas'=>$request->kode,
            'namaberkas'=>$request->berkas
        ]);

        return redirect('/berkas');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\berkas  $berkas
     * @return \Illuminate\Http\Response
     */
    public function show(berkas $berkas)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\berkas  $berkas
     * @return \Illuminate\Http\Response
     */
    public function edit(berkas $berka)
    {
        return view('berkas.update',[
            'data'=>$berka
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateberkasRequest  $request
     * @param  \App\Models\berkas  $berkas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, berkas $berka)
    {
        $request->validate([
            'kode'=>'required|min:2|max:2',
            'kode'=>'numeric',
            'berkas'=>'required|'
        ]);

        $berka->update([
            'kodeberkas'=>$request->kode,
            'namaberkas'=>$request->berkas
        ]);

        return redirect('/berkas');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\berkas  $berkas
     * @return \Illuminate\Http\Response
     */
    public function destroy(berkas $berka)
    {
        $berka->delete();
        return redirect('/berkas');
    }
}
