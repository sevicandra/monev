<?php

namespace App\Http\Controllers;

use App\Models\pagu;
use Illuminate\Http\Request;
use App\Http\Requests\StorepaguRequest;
use App\Http\Requests\UpdatepaguRequest;

class PaguController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pagu.index');
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
     * @param  \App\Http\Requests\StorepaguRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\pagu  $pagu
     * @return \Illuminate\Http\Response
     */
    public function show(pagu $pagu)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\pagu  $pagu
     * @return \Illuminate\Http\Response
     */
    public function edit(pagu $pagu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatepaguRequest  $request
     * @param  \App\Models\pagu  $pagu
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatepaguRequest $request, pagu $pagu)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\pagu  $pagu
     * @return \Illuminate\Http\Response
     */
    public function destroy(pagu $pagu)
    {
        //
    }
}
