<?php

namespace App\Http\Controllers;

use App\Models\tagihan;
use App\Models\register;
use App\Models\register_tagihan;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\Storeregister_tagihanRequest;
use App\Http\Requests\Updateregister_tagihanRequest;

class RegisterTagihanController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\Storeregister_tagihanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(register $register, tagihan $tagihan)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        register_tagihan::create([
            'register_id'=>$register->id,
            'tagihan_id'=>$tagihan->id,
        ]);
        return redirect('/register/'.$register->id.'/create')->with('berhasil', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\register_tagihan  $register_tagihan
     * @return \Illuminate\Http\Response
     */
    public function show(register_tagihan $register_tagihan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\register_tagihan  $register_tagihan
     * @return \Illuminate\Http\Response
     */
    public function edit(register_tagihan $register_tagihan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\Updateregister_tagihanRequest  $request
     * @param  \App\Models\register_tagihan  $register_tagihan
     * @return \Illuminate\Http\Response
     */
    public function update(Updateregister_tagihanRequest $request, register_tagihan $register_tagihan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\register_tagihan  $register_tagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy(register $register, tagihan $tagihan)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        register_tagihan::where('tagihan_id', $tagihan->id)->where('register_id', $register->id)->delete();
        return redirect('/register/'. $register->id)->with('berhasil', 'Data Berhasil Di Hapus');      
    }
    
}
