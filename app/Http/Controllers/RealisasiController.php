<?php

namespace App\Http\Controllers;

use App\Models\pagu;
use App\Models\tagihan;
use App\Models\realisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\UpdaterealisasiRequest;

class RealisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(tagihan $tagihan)
    {
        if (! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
            abort(403);
        }

        return view('tagihan.realisasi.index',[
            'data'=>$tagihan
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
     * @param  \App\Http\Requests\StorerealisasiRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(tagihan $tagihan, pagu $pagu)
    {
        if (! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
            abort(403);
        }
        if ($pagu->mapingppk->user_id != auth()->user()->mapingstafppk->ppk_id) {
            abort(403);
        }

        if ($tagihan->status != 0) {
            return abort(403);
        }
        realisasi::create([
            'pagu_id'=>$pagu->id,
            'tagihan_id'=>$tagihan->id,
            'realisasi'=>0
        ]);
        return redirect('/tagihan/'.$tagihan->id.'/realisasi')->with('berhasil', 'Realisasi Berhasil Di Tambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\realisasi  $realisasi
     * @return \Illuminate\Http\Response
     */
    public function show(tagihan $realisasi)
    {
        if (! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if ($realisasi->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
            abort(403);
        }

        return view('tagihan.realisasi.tarik_detail_akun',[
            'data'=>$realisasi,
            'pagu'=>pagu::Pagusatker()->paguppk()->get()
        ]); 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\realisasi  $realisasi
     * @return \Illuminate\Http\Response
     */
    public function edit(realisasi $realisasi)
    {
        if (! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if ($realisasi->tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
            abort(403);
        }

        if ($realisasi->tagihan->status != 0) {
            return abort(403);
        }
        return view('tagihan.realisasi.update',[
            'data'=>$realisasi,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdaterealisasiRequest  $request
     * @param  \App\Models\realisasi  $realisasi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, realisasi $realisasi)
    {
        if (! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if ($realisasi->tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
            abort(403);
        }

        if ($realisasi->tagihan->status != 0) {
            return abort(403);
        }

        $request->validate([
            'realisasi'=>'required'
        ]);

        $realisasi->update([
            'realisasi'=>$request->realisasi
        ]);

        return redirect('/tagihan/'.$realisasi->tagihan->id.'/realisasi')->with('berhasil', 'Realisasi Berhasil Di Ubah.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\realisasi  $realisasi
     * @return \Illuminate\Http\Response
     */
    public function destroy(realisasi $realisasi)
    {
        if (! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if ($realisasi->tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
            abort(403);
        }

        if ($realisasi->tagihan->status > 0) {
            return abort(403);
        }
        $tagihan=$realisasi->tagihan;
        $realisasi->delete();
        return redirect('/tagihan/'.$tagihan->id.'/realisasi')->with('berhasil', 'Realisasi Berhasil Di Hapus');
    }
    
}
