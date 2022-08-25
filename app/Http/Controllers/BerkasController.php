<?php

namespace App\Http\Controllers;

use App\Models\berkas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreberkasRequest;
use App\Http\Requests\UpdateberkasRequest;

class BerkasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.berkas.index',[
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
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.berkas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreberkasRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
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
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\berkas  $berkas
     * @return \Illuminate\Http\Response
     */
    public function edit(berkas $berka)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.berkas.update',[
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
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
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
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $berka->delete();
        return redirect('/berkas');
    }
}
