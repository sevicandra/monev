<?php

namespace App\Http\Controllers;

use App\Models\pagu;
use App\Models\User;
use App\Models\mapingpaguppk;
use App\Models\mapingstafppk;
use Illuminate\Support\Facades\Gate;

class MapingppkController extends Controller
{
    public function index()
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        return view('referensi.maping_ppk.index',[
            'data'=>User::pegawaisatker()->ppk()->search()->paginate(15)->withQueryString()
        ]);
    }

    public function showpagu(User $ppk)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($ppk->satker != auth()->user()->satker){
            abort(403);
        }

        return view('referensi.maping_ppk.pagu.detail',[
            'data'=>$ppk->paguppk() ->searchprogram()  
                                    ->searchkegiatan()
                                    ->searchkro()
                                    ->searchro()
                                    ->searchkomponen()
                                    ->searchsubkomponen()
                                    ->searchakun()->paginate(15)->withQueryString(),
            'ppk'=>$ppk
        ]);
    }

    public function showstaf(User $ppk)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($ppk->satker != auth()->user()->satker){
            abort(403);
        }

        return view('referensi.maping_ppk.staf.detail',[
            'data'=>$ppk->stafppk()->search()->paginate(15)->withQueryString(),
            'ppk'=>$ppk
        ]);
    }

    public function editpagu(User $ppk)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($ppk->satker != auth()->user()->satker){
            abort(403);
        }

        return view('referensi.maping_ppk.pagu.update',[
            'data'=>pagu::where('kodesatker', auth()->user()->satker)->where('tahun', session()->get('tahun'))->Order()->pagunonppk()   ->searchprogram()  
                                                                                                                                        ->searchkegiatan()
                                                                                                                                        ->searchkro()
                                                                                                                                        ->searchro()
                                                                                                                                        ->searchkomponen()
                                                                                                                                        ->searchsubkomponen()
                                                                                                                                        ->searchakun()->paginate(15)->withQueryString(),
            'ppk'=>$ppk
        ]);
    }

    public function editstaf(User $ppk)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($ppk->satker != auth()->user()->satker){
            abort(403);
        }

        return view('referensi.maping_ppk.staf.update',[
            'data'=>User::stafnoppk()->search()->paginate(15)->withQueryString(),
            'ppk'=>$ppk
        ]);
    }

    public function updatepagu(User $ppk, pagu $pagu)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($ppk->satker != auth()->user()->satker){
            abort(403);
        }

        if($ppk->satker != $pagu->kodesatker){
            abort(403);
        }

        mapingpaguppk::create([
            'pagu_id'=>$pagu->id,
            'user_id'=>$ppk->nip
        ]);
        return Redirect()->back()->with('berhasil', 'Pagu Berhasil Ditambahkan Ke PPK '.$ppk->nama);
        return redirect('/maping-ppk/'.$ppk->id.'/pagu/edit')->with('berhasil', 'Pagu Berhasil Ditambahkan Ke PPK '.$ppk->nama);
    }

    public function updatestaf(User $ppk, User $staf)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($ppk->satker != auth()->user()->satker){
            abort(403);
        }

        if($ppk->satker != $staf->satker){
            abort(403);
        }

        mapingstafppk::create([
            'staf_id'=>$staf->nip,
            'ppk_id'=>$ppk->nip
        ]);
        return redirect('/maping-ppk/'.$ppk->id.'/staf/edit')->with('berhasil', 'staf Berhasil Ditambahkan Ke PPK '.$ppk->nama);
    }

    public function destroypagu(User $ppk, mapingpaguppk $mapingppk)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($ppk->satker != auth()->user()->satker){
            abort(403);
        }

        $mapingppk->delete();
        return redirect('/maping-ppk/'.$ppk->id.'/pagu')->with('berhasil', 'Pagu Berhasil Di Hapus dari PPK');
    }

    public function destroystaf(User $ppk, mapingstafppk $mapingstafppk)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if($ppk->satker != auth()->user()->satker){
            abort(403);
        }

        $mapingstafppk->delete();
        return redirect('/maping-ppk/'.$ppk->id.'/staf')->with('berhasil', 'Pagu Berhasil Di Hapus dari PPK');
    }
}
