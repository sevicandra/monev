<?php

namespace App\Http\Controllers;

use App\Models\pagu;
use App\Models\unit;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreunitRequest;
use App\Http\Requests\UpdateunitRequest;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        return view('referensi.unit.index',[
            'data'=>unit::myunit()->search()->orderby('kodeunit')->paginate(15)->withQueryString()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        return view('referensi.unit.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreunitRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        $request->validate([
            'kodeunit'=>'required|unique|min:2|max:2',
            'namaunit'=>'required'
        ]);

        $request->validate([
            'kodeunit'=>'numeric',
        ]);

        unit::create([
            'kodeunit'=>$request->kodeunit,
            'namaunit'=>$request->namaunit,
            'kodesatker'=>auth()->user()->satker,
        ]);

        return redirect('/unit');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function show(unit $unit)
    {
        //
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\unit  $unit
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateunitRequest  $request
     * @param  \App\Models\unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, unit $unit)
    {
        if (! Gate::allows('admin_satker', auth()->user()->id)) {
            abort(403);
        }

        if ($unit->kodesatker != auth()->user()->satker) {
            abort(403);
        }

        $request->validate([
            'kodeunit'=>'required|unique|min:2|max:2',
            'kodeunit'=>'numeric',
            'namaunit'=>'required'
        ]);

        $unit->update([
            'kodeunit'=>$request->kodeunit,
            'namaunit'=>$request->namaunit,
        ]);

        return redirect('/unit');
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

        $unit->verifikator()->attach($verifikator->id);
        return redirect('/unit/'.$unit->id.'/verifikator/create')->with('berhasil', $verifikator->nama. ' Berhasil Ditambahkan Ke Unit '.$unit->namaunit);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\unit  $unit
     * @return \Illuminate\Http\Response
     */
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

        $unit->verifikator()->detach($verifikator->id);
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
            'data'=>pagu::where('kodesatker', auth()->user()->satker)->where('tahun', session()->get('tahun'))->where('kodeunit', null)->Order() ->searchprogram()  
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

        $pagu->update(['kodeunit'=>$unit->id]);
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
