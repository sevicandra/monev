<?php

namespace App\Http\Controllers;

use App\Models\dnp;
use App\Models\tagihan;
use App\Models\nominaldnp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StorenominaldnpRequest;
use App\Http\Requests\UpdatenominaldnpRequest;

class NominaldnpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(tagihan $tagihan, $dnp)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if ($tagihan->status > 0) {
            return abort(403);
        }
        return view('tagihan.dnp.nominal_dnp.index',[
            'tagihan'=>$tagihan->id,
            'dnp'=>$dnp
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorenominaldnpRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,tagihan $tagihan,dnp $dnp)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if ($tagihan->status != 0) {
            return abort(403);
        }
        $request->validate([
            'bruto'=>'required|numeric'
        ]);

        if ($tagihan->dokumen->statuspph === "1") {
            $tarifpph = $dnp->pph->tarifpph;
            $pph=$request->bruto*$tarifpph;
        }else{
            $pph=0;
        }

        nominaldnp::create([
            'bruto'=>$request->bruto,
            'pph'=>$pph,
            'netto'=>$request->bruto-$pph,
            'dnp_id'=>$dnp->id,
        ]);
        if ($tagihan->nominaldnp->sum('bruto') != $tagihan->realisasi->sum('realisasi')) {
            return redirect('/tagihan/'.$tagihan->id.'/dnp/')->with('pesan', 'Nilai DNP Tidak Sama Dengan Realisasi');
        }
        return redirect('/tagihan/'.$tagihan->id.'/dnp/')->with('berhasil', 'Nilai DNP Telah Sesuai Dengan Realisasi');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\nominaldnp  $nominaldnp
     * @return \Illuminate\Http\Response
     */
    public function show(nominaldnp $nominaldnp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\nominaldnp  $nominaldnp
     * @return \Illuminate\Http\Response
     */
    public function edit(tagihan $tagihan,  $dnp ,nominaldnp $nominaldnp)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if ($tagihan->status != 0) {
            return abort(403);
        }
        return view('tagihan.dnp.nominal_dnp.update',[
            'data'=>$nominaldnp,
            'tagihan'=>$tagihan->id,
            'dnp'=>$dnp
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatenominaldnpRequest  $request
     * @param  \App\Models\nominaldnp  $nominaldnp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,tagihan $tagihan,dnp  $dnp ,nominaldnp $nominaldnp)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if ($tagihan->status != 0) {
            return abort(403);
        }
        $request->validate([
            'bruto'=>'required|numeric'
        ]);

        if ($tagihan->dokumen->statuspph === "1") {
            $tarifpph = $dnp->pph->tarifpph;
            $pph=$request->bruto*$tarifpph;
        }else{
            $pph=0;
        }

        $nominaldnp->update([
            'bruto'=>$request->bruto,
            'pph'=>$pph,
            'netto'=>$request->bruto-$pph,
        ]);

        if ($tagihan->nominaldnp->sum('bruto') != $tagihan->realisasi->sum('realisasi')) {
            return redirect('/tagihan/'.$tagihan->id.'/dnp/')->with('pesan', 'Nilai DNP Tidak Sama Dengan Realisasi');
        }
        return redirect('/tagihan/'.$tagihan->id.'/dnp/')->with('berhasil', 'Nilai DNP Telah Sesuai Dengan Realisasi');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\nominaldnp  $nominaldnp
     * @return \Illuminate\Http\Response
     */
    public function destroy(nominaldnp $nominaldnp)
    {
        //
    }
}
