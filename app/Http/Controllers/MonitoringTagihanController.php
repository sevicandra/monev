<?php

namespace App\Http\Controllers;

use App\Models\tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class MonitoringTagihanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        return view('monitoring_tagihan.index',[
            'data'=>tagihan::tagihansatker()->tagihanppk()->where('tahun', session()->get('tahun'))->get()
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
     * @param  \App\Models\tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function show(tagihan $monitoring_tagihan)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if (Gate::allows('PPK', auth()->user()->id)) {
            if ($monitoring_tagihan->ppk_id != auth()->user()->id) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK', auth()->user()->id)) {
            if ($monitoring_tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
                abort(403);
            }
        }
        return view('monitoring_tagihan.dokumen',[
            'data'=>$monitoring_tagihan
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function edit(tagihan $tagihan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, tagihan $tagihan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy(tagihan $tagihan)
    {
        //
    }
}
