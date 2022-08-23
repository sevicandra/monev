<?php

namespace App\Http\Controllers;

use App\Models\spm;
use App\Http\Requests\StorespmRequest;
use App\Http\Requests\UpdatespmRequest;

class SpmController extends Controller
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
     * @param  \App\Http\Requests\StorespmRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorespmRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\spm  $spm
     * @return \Illuminate\Http\Response
     */
    public function show(spm $spm)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\spm  $spm
     * @return \Illuminate\Http\Response
     */
    public function edit(spm $spm)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatespmRequest  $request
     * @param  \App\Models\spm  $spm
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatespmRequest $request, spm $spm)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\spm  $spm
     * @return \Illuminate\Http\Response
     */
    public function destroy(spm $spm)
    {
        //
    }
}
