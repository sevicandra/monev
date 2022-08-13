<?php

namespace App\Http\Controllers;

use App\Models\dnp;
use App\Models\tagihan;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use App\Http\Requests\UpdatednpRequest;

class DnpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(tagihan $tagihan)
    {
        if ($tagihan->dokumen->statusdnp != '1') {
            abort(403);
        }
        return view('dnp.index',[
            'data'=>$tagihan
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(tagihan $tagihan)
    {
        if ($tagihan->dokumen->statusdnp != '1') {
            abort(403);
        }
        if (request('nama')) {
            $response = Http::withBasicAuth(config('alika.id'), config('alika.password'))->get(config('alika.uri').'data-pegawai',[
                'keyword'=>request('nama'),
                'limit' => null,
                'offset' => 0,
                'X-API-KEY'=>config('alika.api'),
            ]);
            return view('dnp.tarik_pegawai_gaji',[
                'data'=>collect(json_decode($response->getBody()->getContents(), false)),
                'tagihan'=>$tagihan
            ]);
        }else{
            return view('dnp.tarik_pegawai_gaji',[
                'data'=>[],
                'tagihan'=>$tagihan
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorednpRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(tagihan $tagihan, $nip)
    {
        if ($tagihan->dokumen->statusdnp != '1') {
            abort(403);
        }
        $response = Http::withBasicAuth(config('alika.id'), config('alika.password'))->get(config('alika.uri').'data-pegawai',[
            'keyword' => $nip,
            'limit' => null,
            'offset' => 0,
            'X-API-KEY'=>config('alika.api'),
        ]);
        
        foreach (collect(json_decode($response->getBody()->getContents(), true)) as $key) {
            $kdgol = substr($key['kdgol'], 0, 1);
            dnp::create([
                'tagihan_id'=>$tagihan->id,
                'nip'=>$key['nip'],
                'nama'=>$key['nmpeg'],
                'kodegolongan'=>$kdgol,
                'rekening'=>$key['rekening'],
                'namabank'=>$key['nm_bank'],
                'namarekening'=>$key['nmrek'],
            ]);
        }

        return redirect('/tagihan/'.$tagihan->id.'/dnp');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\dnp  $dnp
     * @return \Illuminate\Http\Response
     */
    public function show(dnp $dnp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\dnp  $dnp
     * @return \Illuminate\Http\Response
     */
    public function edit(dnp $dnp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatednpRequest  $request
     * @param  \App\Models\dnp  $dnp
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatednpRequest $request, dnp $dnp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\dnp  $dnp
     * @return \Illuminate\Http\Response
     */
    public function destroy(tagihan $tagihan, dnp $dnp)
    {
        $dnp->delete();
        return redirect('/tagihan/'.$tagihan->id.'/dnp');
    }
}
