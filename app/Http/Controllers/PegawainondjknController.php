<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\pegawainondjkn;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StorepegawainondjknRequest;
use App\Http\Requests\UpdatepegawainondjknRequest;

class PegawainondjknController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('PPK', auth()->user()->id) && ! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        return view('pegawai_nondjkn.index',[
            'data'=>pegawainondjkn::search()->paginate(15)->withQueryString()
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
        return view('pegawai_nondjkn.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorepegawainondjknRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        $request->validate([
            'nip'=>'required|numeric',
            'nama'=>'required',
            'kodegolongan'=>'required|min:2|max:2',
            'rekening'=>'required|numeric',
            'namabank'=>'required',
            'namarekening'=>'required'
        ]);
        pegawainondjkn::create([
            'nip'=>$request->nip,
            'nama'=>$request->nama,
            'kodegolongan'=>$request->kodegolongan,
            'rekening'=>$request->rekening,
            'namabank'=>$request->namabank,
            'namarekening'=>$request->namarekening
        ]);
        return redirect('/pegawai-nondjkn')->with('berhasil', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pegawainondjkn  $pegawainondjkn
     * @return \Illuminate\Http\Response
     */
    public function show(pegawainondjkn $pegawainondjkn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pegawainondjkn  $pegawainondjkn
     * @return \Illuminate\Http\Response
     */
    public function edit(pegawainondjkn $pegawai_nondjkn)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        return view('pegawai_nondjkn.update',[
            'data'=>$pegawai_nondjkn
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepegawainondjknRequest  $request
     * @param  \App\Models\pegawainondjkn  $pegawainondjkn
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pegawainondjkn $pegawai_nondjkn)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        $request->validate([
            'nip'=>'required|numeric',
            'nama'=>'required',
            'kodegolongan'=>'required|min:2|max:2',
            'rekening'=>'required|numeric',
            'namabank'=>'required',
            'namarekening'=>'required'
        ]);
        $pegawai_nondjkn->update([
            'nip'=>$request->nip,
            'nama'=>$request->nama,
            'kodegolongan'=>$request->kodegolongan,
            'rekening'=>$request->rekening,
            'namabank'=>$request->namabank,
            'namarekening'=>$request->namarekening
        ]);
        return redirect('/pegawai-nondjkn')->with('berhasil', 'Data Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pegawainondjkn  $pegawainondjkn
     * @return \Illuminate\Http\Response
     */
    public function destroy(pegawainondjkn $pegawai_nondjkn)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        $pegawai_nondjkn->delete();
        return redirect('/pegawai-nondjkn')->with('berhasil', 'Data Berhasil Di Hapus');
    }
}
