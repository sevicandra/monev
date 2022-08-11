<?php

namespace App\Http\Controllers;

use App\Models\pph;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PphController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('pph.index',[
            'data'=>pph::orderby('kodegolongan', 'DESC')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('pph.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorepphRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $request->validate([
            'kodegolongan'=>'required|unique|min:1|max:1',
            'kodegolongan'=>'numeric',
            'tarifpph'=>'required|numeric'
        ]);

        pph::create([
            'kodegolongan'=>$request->kodegolongan,
            'tarifpph'=>$request->tarifpph
        ]);
        return redirect('/pph');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pph  $pph
     * @return \Illuminate\Http\Response
     */
    public function show(pph $pph)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pph  $pph
     * @return \Illuminate\Http\Response
     */
    public function edit(pph $pph)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('pph.update',[
            'data'=>$pph
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepphRequest  $request
     * @param  \App\Models\pph  $pph
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, pph $pph)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $request->validate([
            'kodegolongan'=>'required|unique|min:1|max:1',
            'kodegolongan'=>'numeric',
            'tarifpph'=>'required|numeric'
        ]);

        $pph->update([
            'kodegolongan'=>$request->kodegolongan,
            'tarifpph'=>$request->tarifpph
        ]);
        return redirect('/pph');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pph  $pph
     * @return \Illuminate\Http\Response
     */
    public function destroy(pph $pph)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $pph->delete();
        return redirect('/pph');
    }
}
