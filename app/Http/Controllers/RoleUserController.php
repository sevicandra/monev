<?php

namespace App\Http\Controllers;

use App\Models\role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(role $role, User $user)
    {
        if (! Gate::any(['admin_satker', 'sys_admin'], auth()->user()->id)) {
            abort(403);
        }

        if ($user->satker != auth()->user()->satker) {
            abort(403);
        }

        $role->user()->attach($user->id);
        return redirect('/role-user/'. $user->id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $role_user)
    {
        if (! Gate::any(['admin_satker', 'sys_admin'], auth()->user()->id)) {
            abort(403);
        }

        if ($role_user->satker != auth()->user()->satker) {
            abort(403);
        }

        return view('referensi.user.role_user.index',[
            'data'=>$role_user
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(User $role_user)
    {
        if (! Gate::any(['admin_satker', 'sys_admin'], auth()->user()->id)) {
            abort(403);
        }

        if ($role_user->satker != auth()->user()->satker) {
            abort(403);
        }
        return view('referensi.user.role_user.create',[
            'data'=>role::orderby('koderole')->ofUser($role_user->id),
            'user'=>$role_user
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(role $role, User $user)
    {
        if (! Gate::any(['admin_satker', 'sys_admin'], auth()->user()->id)) {
            abort(403);
        }

        if ($user->satker != auth()->user()->satker) {
            abort(403);
        }
        $role->user()->detach($user->id);
        return redirect('/role-user/'. $user->id);
    }
}
