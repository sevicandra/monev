<?php

namespace App\Http\Controllers;

use App\Models\pagu;
use App\Models\tagihan;
use App\Models\realisasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RealisasiController extends Controller
{
    public function index(tagihan $tagihan)
    {
        if (! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
            abort(403);
        }

        return view('tagihan.realisasi.index',[
            'data'=>$tagihan->realisasi()   ->searchprogram()  
                                            ->searchkegiatan()
                                            ->searchkro()
                                            ->searchro()
                                            ->searchkomponen()
                                            ->searchsubkomponen()
                                            ->searchakun()->paginate(15)->withQueryString(),
            'tagihan'=>$tagihan
        ]);
    }

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
            'pagu'=>pagu::Pagusatker()->paguppk()->pagustafppk()    ->searchprogram()  
                                                                    ->searchkegiatan()
                                                                    ->searchkro()
                                                                    ->searchro()
                                                                    ->searchkomponen()
                                                                    ->searchsubkomponen()
                                                                    ->searchakun()->paginate(15)->withQueryString()
        ]); 
    }

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
