<?php

namespace App\Http\Controllers;

use App\Models\tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ArsipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('arsip.index',[
            'data'=>tagihan::arsip()->orderby('notagihan', 'desc')->get()
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
    public function show(tagihan $tagihan)
    {
        //
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

    public function dokumen(tagihan $tagihan)
    {
        if ($tagihan->status != 5) {
            abort(403);
        }
        return view('arsip.dokumen',[
            'data'=>$tagihan
        ]);
    }

    public function coa(tagihan $tagihan)
    {
        if ($tagihan->status != 5) {
            abort(403);
        }
        return view('arsip.coa',[
            'data'=>$tagihan
        ]);
    }

    public function dnp(tagihan $tagihan)
    {
        if ($tagihan->status != 5) {
            abort(403);
        }
        return view('arsip.dnp',[
            'data'=>$tagihan
        ]);
    }

    public function tolak(tagihan $tagihan)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }
        if ($tagihan->status != 5) {
            abort(403);
        }
        $tagihan->update([
            'status'=>4
        ]);
        return redirect('/arsip')->with('berhasil', 'Tagihan Berhasil Di Tolak');
    }
}
