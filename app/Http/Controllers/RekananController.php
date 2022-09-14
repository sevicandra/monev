<?php

namespace App\Http\Controllers;

use App\Models\rekanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StorerekananRequest;
use App\Http\Requests\UpdaterekananRequest;

class RekananController extends Controller
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
        return view('referensi.rekanan.index',[
            'data'=>rekanan::rekanansatker()->search()->paginate(15)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.rekanan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorerekananRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        $request->validate([
            'nama'=>'required',
            'idpajak'=>'required|numeric'
        ]);

        if ($request->npwp) {
            $request->validate([
                'idpajak'=>'min:15|max:15'
            ]);
            $npwp=true;
        }else{
            $request->validate([
                'idpajak'=>'min:16|max:16'
            ]);
            $npwp=false;
        }

        rekanan::create([
            'nama'=>$request->nama,
            'idpajak'=>$request->idpajak,
            'npwp'=>$npwp,
            'kodesatker'=>auth()->user()->satker
        ]);

        return redirect('/rekanan')->with('berhasil','Rekanan Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\rekanan  $rekanan
     * @return \Illuminate\Http\Response
     */
    public function show(rekanan $rekanan)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\rekanan  $rekanan
     * @return \Illuminate\Http\Response
     */
    public function edit(rekanan $rekanan)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if ($rekanan->kodesatker != auth()->user()->satker) {
            abort(403);
        }
        return view('referensi.rekanan.update',[
            'data'=>$rekanan
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdaterekananRequest  $request
     * @param  \App\Models\rekanan  $rekanan
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, rekanan $rekanan)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if ($rekanan->kodesatker != auth()->user()->satker) {
            abort(403);
        }
        $request->validate([
            'nama'=>'required',
            'idpajak'=>'required|numeric'
        ]);

        if ($request->npwp) {
            $request->validate([
                'idpajak'=>'min:15|max:15'
            ]);
            $npwp=true;
        }else{
            $request->validate([
                'idpajak'=>'min:16|max:16'
            ]);
            $npwp=false;
        }

        $rekanan->update([
            'nama'=>$request->nama,
            'idpajak'=>$request->idpajak,
            'npwp'=>$npwp,
        ]);

        return redirect('/rekanan')->with('berhasil','Rekanan Berhasil di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\rekanan  $rekanan
     * @return \Illuminate\Http\Response
     */
    public function destroy(rekanan $rekanan)
    {
        
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if ($rekanan->kodesatker != auth()->user()->satker) {
            abort(403);
        }
    }
}
