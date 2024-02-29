<?php

namespace App\Http\Controllers;

use App\Models\tagihan;
use App\Models\register;
use App\Models\register_tagihan;
use Illuminate\Support\Facades\Gate;

class RegisterTagihanController extends Controller
{
    public function store(register $register, tagihan $tagihan)
    {
        if (! Gate::allows('PPK')&&! Gate::allows('Staf_PPK')) {
            abort(403);
        }
        register_tagihan::create([
            'register_id'=>$register->id,
            'tagihan_id'=>$tagihan->id,
        ]);
        return redirect('/register/'.$register->id.'/create')->with('berhasil', 'Data Berhasil Ditambahkan');
    }

    public function destroy(register $register, tagihan $tagihan)
    {
        if (! Gate::allows('PPK')&&! Gate::allows('Staf_PPK')) {
            abort(403);
        }
        register_tagihan::where('tagihan_id', $tagihan->id)->where('register_id', $register->id)->delete();
        return redirect('/register/'. $register->id)->with('berhasil', 'Data Berhasil Di Hapus');      
    }
    
}
