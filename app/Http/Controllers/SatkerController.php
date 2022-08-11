<?php

namespace App\Http\Controllers;

use App\Models\satker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SatkerController extends Controller
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
        return view('satker.index',[
            'data'=>satker::all()
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
        return view('satker.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoresatkerRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        if ($request['kodesatkerkoordinator'] != null) {
            return $request;
            $request->validate([
                'kodesatkerkoordinator'=>'min:6|max:6',
            ]);
            $request->validate([
                'kodesatkerkoordinator'=>'numeric',
            ]);
        }

        $request->validate([
            'kodesatker'=>'required|min:6|max:6|unique:satkers',
            'namasatker'=>'required',
        ]);

        $request->validate([
            'kodesatker'=>'numeric',
        ]);

        satker::create([
            'kodesatker'=>$request['kodesatker'],
            'kodesatkerkoordinator'=>$request['kodesatkerkoordinator'],
            'namasatker'=>$request['namasatker'],
        ]);

        return redirect('/satker');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\satker  $satker
     * @return \Illuminate\Http\Response
     */
    public function show(satker $satker)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\satker  $satker
     * @return \Illuminate\Http\Response
     */
    public function edit(satker $satker)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('satker.update',[
            'data'=> $satker
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatesatkerRequest  $request
     * @param  \App\Models\satker  $satker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, satker $satker)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        if ($request['kodesatkerkoordinator'] != null) {
            return $request;
            $request->validate([
                'kodesatkerkoordinator'=>'min:6|max:6',
            ]);
            $request->validate([
                'kodesatkerkoordinator'=>'numeric',
            ]);
        }

        $request->validate([
            'kodesatker'=>'required|min:6|max:6',
            'namasatker'=>'required',
        ]);

        $request->validate([
            'kodesatker'=>'numeric',
        ]);

        $satker->update([
            'kodesatker'=>$request['kodesatker'],
            'kodesatkerkoordinator'=>$request['kodesatkerkoordinator'],
            'namasatker'=>$request['namasatker'],
        ]);

        return redirect('/satker');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\satker  $satker
     * @return \Illuminate\Http\Response
     */
    public function destroy(satker $satker)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $satker->delete();
        return redirect('/satker');
    }
}
