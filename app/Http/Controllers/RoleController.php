<?php

namespace App\Http\Controllers;

use App\Models\role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
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
        return view('referensi.role.index',[
            'data'=>role::orderby('koderole')->get()
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
        return view('referensi.role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreroleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $request->validate([
            'koderole'=>'required|min:2|max:2',
            'role'=>'required'
        ]);

        $request->validate([
            'koderole'=>'numeric',
        ]);

        role::create([
            'koderole'=>$request->koderole,
            'role'=>$request->role
        ]);

        return Redirect('/role');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(role $role)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit(role $role)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.role.update',[
            'data'=>$role,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateroleRequest  $request
     * @param  \App\Models\role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, role $role)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }

        $request->validate([
            'koderole'=>'required|min:2|max:2',
            'role'=>'required'
        ]);

        $request->validate([
            'koderole'=>'numeric',
        ]);

        $role->update([
            'koderole'=>$request->koderole,
            'role'=>$request->role
        ]);

        return Redirect('/role');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(role $role)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }

        $role->delete();
        return Redirect('/role');
    }
}
