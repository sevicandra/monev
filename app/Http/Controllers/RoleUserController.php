<?php

namespace App\Http\Controllers;

use App\Models\role;
use App\Models\User;
use App\Helper\Notification;
use Illuminate\Support\Facades\Gate;

class RoleUserController extends Controller
{

    public function create(role $role, User $user)
    {
        if (! Gate::any(['admin_satker', 'sys_admin'])) {
            abort(403);
        }
        if (!Gate::allows('sys_admin')) {
            if ($user->satker != auth()->user()->satker) {
                abort(403);
            }
        }

        $role->user()->attach($user->nip);
        return redirect('/role-user/'. $user->id);
    }

    public function show(User $role_user)
    {
        if (! Gate::any(['admin_satker', 'sys_admin'])) {
            abort(403);
        }

        if (!Gate::allows('sys_admin')) {
            if ($role_user->satker != auth()->user()->satker) {
                abort(403);
            }
        }

        return view('referensi.user.role_user.index',[
            'data'=>$role_user,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function edit(User $role_user)
    {
        if (! Gate::any(['admin_satker', 'sys_admin'])) {
            abort(403);
        }

        if (!Gate::allows('sys_admin')) {
            if ($role_user->satker != auth()->user()->satker) {
                abort(403);
            }
        }

        return view('referensi.user.role_user.create',[
            'data'=>role::orderby('koderole')->ofUser($role_user->id),
            'user'=>$role_user,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function destroy(role $role, User $user)
    {
        if (! Gate::any(['admin_satker', 'sys_admin'])) {
            abort(403);
        }

        if (!Gate::allows('sys_admin')) {
            if ($user->satker != auth()->user()->satker) {
                abort(403);
            }
        }

        $role->user()->detach($user->nip);
        return redirect('/role-user/'. $user->id);
    }
}
