<?php

namespace App\Http\Controllers;

use App\Helper\Notification;
use Illuminate\Http\Request;
use App\Models\pegawainondjkn;
use Illuminate\Support\Facades\Gate;

class PegawainondjknController extends Controller
{
    public function index()
    {
        if (! Gate::allows('PPK', auth()->user()->id) && ! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        return view('pegawai_nondjkn.index',[
            'data'=>pegawainondjkn::search()->paginate(15)->withQueryString(),
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function create()
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        return view('pegawai_nondjkn.create',[
            'notifikasi'=>Notification::Notif()
        ]);
    }

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

    public function edit(pegawainondjkn $pegawai_nondjkn)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        return view('pegawai_nondjkn.update',[
            'data'=>$pegawai_nondjkn,
            'notifikasi'=>Notification::Notif()
        ]);
    }

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

    public function destroy(pegawainondjkn $pegawai_nondjkn)
    {
        if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }
        $pegawai_nondjkn->delete();
        return redirect('/pegawai-nondjkn')->with('berhasil', 'Data Berhasil Di Hapus');
    }
}
