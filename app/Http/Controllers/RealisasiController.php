<?php

namespace App\Http\Controllers;

use App\Models\pagu;
use App\Models\tagihan;
use App\Models\realisasi;
use App\Http\Requests\UpdaterealisasiRequest;
use Illuminate\Http\Request;

class RealisasiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(tagihan $tagihan)
    {
        return view('realisasi.index',[
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
        return view('realisasi.tarik_detail_akun',[
            'data'=>$realisasi,
            'pagu'=>pagu::Pagusatker()->get()
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
        if ($realisasi->tagihan->status != 0) {
            return abort(403);
        }
        return view('realisasi.update',[
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
        if ($realisasi->tagihan->status > 0) {
            return abort(403);
        }
        $tagihan=$realisasi->tagihan;
        $realisasi->delete();
        return redirect('/tagihan/'.$tagihan->id.'/realisasi')->with('berhasil', 'Realisasi Berhasil Di Hapus');
    }
    
}
