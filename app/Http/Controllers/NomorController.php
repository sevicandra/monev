<?php

namespace App\Http\Controllers;

use App\Models\nomor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StorenomorRequest;
use App\Http\Requests\UpdatenomorRequest;

class NomorController extends Controller
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

        return view('referensi.nomor.index',[
            'data'=>nomor::all()
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
        
        return view('referensi.nomor.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorenomorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }

        $request->validate([
            'nomor'=>'required|numeric',
            'tahun'=>'required|min:4|max:4',
            'kodesatker'=>'required|min:6|max:6'
        ]);

        $request->validate([
            'kodesatker'=>'numeric',
            'tahun'=>'numeric',
        ]);

        nomor::create([
            'nomor'=>$request->nomor,
            'ekstensi'=>'/'.$request->kodesatker.'/',
            'kodesatker'=>$request->kodesatker,
            'tahun'=>$request->tahun,
        ]);

        return redirect('/nomor');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\nomor  $nomor
     * @return \Illuminate\Http\Response
     */
    public function show(nomor $nomor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\nomor  $nomor
     * @return \Illuminate\Http\Response
     */
    public function edit(nomor $nomor)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }

        return view('referensi.nomor.update',[
            'data'=>$nomor
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatenomorRequest  $request
     * @param  \App\Models\nomor  $nomor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, nomor $nomor)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }

        $request->validate([
            'nomor'=>'required|numeric'
        ]);

        $nomor->update([
            'nomor'=>$request->nomor
        ]);
        return redirect('/nomor');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\nomor  $nomor
     * @return \Illuminate\Http\Response
     */
    public function destroy(nomor $nomor)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        
        $nomor->delete();
        return redirect('/nomor');
    }
}
