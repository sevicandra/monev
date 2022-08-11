<?php

namespace App\Http\Controllers;

use App\Models\tahun;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TahunController extends Controller
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
        return view('tahun.index',[
            'data'=>tahun::orderby('tahun')->get()
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
        return view('tahun.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoretahunRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $request->validate([
            'tahun'=>'required|numeric|min:2020'
        ]);

        tahun::create([
            'tahun'=>$request->tahun
        ]);

        return redirect('/tahun');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\tahun  $tahun
     * @return \Illuminate\Http\Response
     */
    public function show(tahun $tahun)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tahun  $tahun
     * @return \Illuminate\Http\Response
     */
    public function edit(tahun $tahun)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('tahun.update',[
            'data'=>$tahun
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatetahunRequest  $request
     * @param  \App\Models\tahun  $tahun
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tahun $tahun)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $request->validate([
            'tahun'=>'required|numeric|min:2020'
        ]);

        $tahun->update([
            'tahun'=>$request->tahun
        ]);

        return redirect('/tahun');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tahun  $tahun
     * @return \Illuminate\Http\Response
     */
    public function destroy(tahun $tahun)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $tahun->delete();
    }
}
