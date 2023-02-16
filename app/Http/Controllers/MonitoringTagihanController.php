<?php

namespace App\Http\Controllers;

use App\Models\rekanan;
use App\Models\tagihan;
use App\Models\pphrekanan;
use App\Models\ppnrekanan;
use App\Models\register_tagihan;
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
            'data'=>tagihan::tagihansatker()->tagihanppk()->where('tahun', session()->get('tahun'))->search()->paginate(15)->withQueryString()
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
    public function show(Request $request,tagihan $monitoring_tagihan)
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
        switch ($request->scope) {
            case 'dokumen':
                return view('monitoring_tagihan.dokumen',[
                    'data'=>$monitoring_tagihan
                ]);
                break;

            case 'histories':
                return view('monitoring_tagihan.detail',[
                    'data'=>$monitoring_tagihan
                ]);
                break;

        }

    }

    public function showcoa(tagihan $tagihan)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if (Gate::allows('PPK', auth()->user()->id)) {
            if ($tagihan->ppk_id != auth()->user()->id) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK', auth()->user()->id)) {
            if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
                abort(403);
            }
        }

        return view('monitoring_tagihan.coa',[
            'data'=>$tagihan->realisasi()   ->searchprogram()  
                                            ->searchkegiatan()
                                            ->searchkro()
                                            ->searchro()
                                            ->searchkomponen()
                                            ->searchsubkomponen()
                                            ->searchakun()->paginate(15)->withQueryString()
        ]);
    }

    public function showdnp(tagihan $tagihan)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if (Gate::allows('PPK', auth()->user()->id)) {
            if ($tagihan->ppk_id != auth()->user()->id) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK', auth()->user()->id)) {
            if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
                abort(403);
            }
        }
        return view('monitoring_tagihan.dnp',[
            'data'=>$tagihan->dnp()->search()->paginate(15)->withQueryString(),
            'tagihan'=>$tagihan
        ]);
    }

    public function showrekanan(tagihan $tagihan)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if (Gate::allows('PPK', auth()->user()->id)) {
            if ($tagihan->ppk_id != auth()->user()->id) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK', auth()->user()->id)) {
            if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
                abort(403);
            }
        }
        return view('monitoring_tagihan.rekanan.index',[
            'data'=>$tagihan->rekanan()->rekanansatker()->search()->paginate(15)->withQueryString(),
            'tagihan'=>$tagihan
        ]);
    }

    public function showppnrekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if (Gate::allows('PPK', auth()->user()->id)) {
            if ($tagihan->ppk_id != auth()->user()->id) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK', auth()->user()->id)) {
            if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
                abort(403);
            }
        }
        return view('monitoring_tagihan.rekanan.ppn.index',[
            'data'=>ppnrekanan::myppn($tagihan, $rekanan)->get(),
            'tagihan'=>$tagihan,
            'rekanan'=>$rekanan
        ]);
    }

    public function showpphrekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if (Gate::allows('PPK', auth()->user()->id)) {
            if ($tagihan->ppk_id != auth()->user()->id) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK', auth()->user()->id)) {
            if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
                abort(403);
            }
        }
        return view('monitoring_tagihan.rekanan.pph.index',[
            'data'=>pphrekanan::mypph($tagihan, $rekanan)->get(),
            'tagihan'=>$tagihan,
            'rekanan'=>$rekanan
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

    public function tolak(tagihan $tagihan)
    {
        if (! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
            abort(403);
        }
        if ($tagihan->status != 1) {
            return abort(403);
        }
        $tagihan->update(['status'=> 0]);
        register_tagihan::where('tagihan_id', $tagihan->id)->delete();
        return redirect('/monitoring-tagihan');
    }
}
