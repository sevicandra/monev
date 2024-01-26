<?php

namespace App\Http\Controllers;

use App\Models\dnp;
use App\Models\tagihan;
use App\Models\nominaldnp;
use App\Helper\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class NominaldnpController extends Controller
{
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
            'dnp'=>$dnp,
            'notifikasi'=>Notification::Notif()
        ]);
    }

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
            'dnp'=>$dnp,
            'notifikasi'=>Notification::Notif()
        ]);
    }

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
}
