<?php

namespace App\Http\Controllers;

use App\Models\role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    public function index()
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.role.index',[
            'data'=>role::orderby('koderole')->get()
        ]);
    }

    public function create()
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.role.create');
    }

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

    public function show(role $role)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
    }

    public function edit(role $role)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.role.update',[
            'data'=>$role,
        ]);
    }

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

    public function destroy(role $role)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }

        $role->delete();
        return Redirect('/role');
    }
}
