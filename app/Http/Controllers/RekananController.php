<?php

namespace App\Http\Controllers;

use App\Models\rekanan;
use App\Helper\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RekananController extends Controller
{
    public function index()
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.rekanan.index',[
            'data'=>rekanan::rekanansatker()->search()->paginate(15)->withQueryString(),
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function create()
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.rekanan.create',[
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function store(Request $request)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        $request->validate([
            'nama'=>'required',
            'idpajak'=>'required|numeric'
        ]);

        $request->validate([
            'idpajak'=>'min:15|max:16'
        ]);
        if ($request->npwp) {
            $npwp=true;
        }else{
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

    public function show(rekanan $rekanan)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        //
    }

    public function edit(rekanan $rekanan)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        if ($rekanan->kodesatker != auth()->user()->satker) {
            abort(403);
        }
        return view('referensi.rekanan.update',[
            'data'=>$rekanan,
            'notifikasi'=>Notification::Notif()
        ]);
    }

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

        $request->validate([
            'idpajak'=>'min:15|max:16'
        ]);
        if ($request->npwp) {
            $npwp=true;
        }else{
            $npwp=false;
        }

        $rekanan->update([
            'nama'=>$request->nama,
            'idpajak'=>$request->idpajak,
            'npwp'=>$npwp,
        ]);

        return redirect('/rekanan')->with('berhasil','Rekanan Berhasil di Ubah');
    }

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
