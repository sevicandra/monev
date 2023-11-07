<?php

namespace App\Http\Controllers;

use App\Models\pagu;
use App\Models\unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UnitController extends Controller
{
    public function index()
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        return view('referensi.unit.index',[
            'data'=>unit::myunit()->search()->orderby('kodeunit')->paginate(15)->withQueryString()
        ]);
    }

    public function create()
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        return view('referensi.unit.create');
    }

    public function store(Request $request)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        $request->validate([
            'kodeunit'=>'required|unique:units|min_digits:2|max_digits:2',
            'namaunit'=>'required'
        ]);


        unit::create([
            'kodeunit'=>$request->kodeunit,
            'namaunit'=>$request->namaunit,
            'kodesatker'=>auth()->user()->satker,
        ]);

        return redirect('/unit')->with('berhasil', 'Unit Berhasil Ditambahkan');
    }

    public function showverifikator(unit $unit)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if ($unit->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('referensi.unit.verifikator.index',[
            'data'=>$unit
        ]);
    }

    public function edit(unit $unit)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if ($unit->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('referensi.unit.update',[
            'data'=>$unit
        ]);
    }

    public function editverifikator(unit $unit)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if ($unit->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('referensi.unit.verifikator.create',[
            'data'=>User::where('satker', auth()->user()->satker)->verifikator()->verifikatornonsign($unit->id)->search()->paginate(15)->withQueryString(),
            'unit'=>$unit
        ]);
    }

    public function update(Request $request, unit $unit)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if ($unit->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        $request->validate([
            'kodeunit'=>'required|unique:units,kodeunit,'.$unit->id.'|min_digits:2|max_digits:2',
            'namaunit'=>'required'
        ]);

        $unit->update([
            'kodeunit'=>$request->kodeunit,
            'namaunit'=>$request->namaunit,
        ]);

        return redirect('/unit')->with('berhasil', 'Unit Berhasil Diubah');
    }

    public function updateverifikator(unit $unit, User $verifikator)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if ($unit->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        if ($unit->kodesatker != $verifikator->satker) {
            abort(403);
        }

        $unit->verifikator()->attach($verifikator->nip);
        return redirect('/unit/'.$unit->id.'/verifikator/create')->with('berhasil', $verifikator->nama. ' Berhasil Ditambahkan Ke Unit '.$unit->namaunit);
    }

    public function destroy(unit $unit)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }
        if ($unit->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        $unit->delete();
        return redirect('/unit');
    }

    public function destroyverifikator(unit $unit, User $verifikator)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }
        
        if ($unit->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        $unit->verifikator()->detach($verifikator->nip);
        return redirect('/unit/'.$unit->id.'/verifikator')->with('berhasil', $verifikator->nama. ' Berhasil Dihapus Dari Unit '.$unit->namaunit);
    }

    public function showpagu(unit $unit)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if ($unit->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('referensi.unit.pagu.detail',[
            'data'=>$unit->pagu() ->searchprogram()  
                                    ->searchkegiatan()
                                    ->searchkro()
                                    ->searchro()
                                    ->searchkomponen()
                                    ->searchsubkomponen()
                                    ->searchakun()->paginate(15)->withQueryString(),
            'unit'=>$unit
        ]);
    }

    public function editpagu(unit $unit)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if ($unit->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        return view('referensi.unit.pagu.update',[
            'data'=>pagu::where('kodesatker', auth()->user()->satker)->where('tahun', session()->get('tahun'))->whereDoesntHave('unit')->Order() ->searchprogram()  
                                                                                                                        ->searchkegiatan()
                                                                                                                        ->searchkro()
                                                                                                                        ->searchro()
                                                                                                                        ->searchkomponen()
                                                                                                                        ->searchsubkomponen()
                                                                                                                        ->searchakun()->paginate(15)->withQueryString(),
            'unit'=>$unit
        ]);
    }

    public function updatepagu(unit $unit, pagu $pagu)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if ($unit->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        $pagu->update(['kodeunit'=>$unit->kodeunit]);
        return Redirect()->back()->with('berhasil', 'Pagu Berhasil Ditambahkan Ke Unit '.$unit->namaunit);
        return redirect('/unit/'.$unit->id.'/pagu/edit')->with('berhasil', 'Pagu Berhasil Ditambahkan Ke Unit '.$unit->namaunit);
    }

    public function destroypagu(unit $unit, pagu $pagu)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if ($unit->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        $pagu->update(['kodeunit'=>null]);
        return redirect('/unit/'.$unit->id.'/pagu')->with('berhasil', 'Pagu Berhasil Di Hapus dari Unit');
    }
}
