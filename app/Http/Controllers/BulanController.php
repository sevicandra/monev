<?php

namespace App\Http\Controllers;

use App\Models\bulan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StorebulanRequest;
use App\Http\Requests\UpdatebulanRequest;

class BulanController extends Controller
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
        return view('referensi.bulan.index',[
            'data'=>bulan::orderby('kodebulan')->get()
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
        return view('referensi.bulan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorebulanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $request->validate([
            'kodebulan'=>'unique|required|min:2|max:2',
            'kodebulan'=>'numeric',
            'namabulan'=>'required'
        ]);

        bulan::create([
            'kodebulan'=>$request->kodebulan,
            'namabulan'=>$request->namabulan,
        ]);

        return redirect('/bulan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\bulan  $bulan
     * @return \Illuminate\Http\Response
     */
    public function show(bulan $bulan)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\bulan  $bulan
     * @return \Illuminate\Http\Response
     */
    public function edit(bulan $bulan)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.bulan.update',[
            'data'=>$bulan
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatebulanRequest  $request
     * @param  \App\Models\bulan  $bulan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, bulan $bulan)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $request->validate([
            'kodebulan'=>'unique|required|min:2|max:2',
            'kodebulan'=>'numeric',
            'namabulan'=>'required'
        ]);

        $bulan->update([
            'kodebulan'=>$request->kodebulan,
            'namabulan'=>$request->namabulan,
        ]);

        return redirect('/bulan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\bulan  $bulan
     * @return \Illuminate\Http\Response
     */
    public function destroy(bulan $bulan)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $bulan->delete();
        return redirect('/bulan');
    }
}
