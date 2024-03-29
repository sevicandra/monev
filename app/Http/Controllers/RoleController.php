<?php

namespace App\Http\Controllers;

use App\Models\role;
use App\Helper\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class RoleController extends Controller
{
    public function index()
    {
        if (!Gate::allows('sys_admin')) {
            abort(403);
        }
        return view('referensi.role.index', [
            'data' => role::orderby('koderole')->get(),
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function create()
    {
        if (!Gate::allows('sys_admin')) {
            abort(403);
        }
        return view('referensi.role.create', [
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function store(Request $request)
    {
        if (!Gate::allows('sys_admin')) {
            abort(403);
        }
        $request->validate([
            'koderole' => 'required|min:2|max:2',
            'role' => 'required'
        ]);

        $request->validate([
            'koderole' => 'numeric',
        ]);

        role::create([
            'koderole' => $request->koderole,
            'role' => $request->role
        ]);

        return Redirect('/role')->with('berhasil', 'Data Berhasil Ditambahkan');
    }

    public function show(role $role)
    {
        if (!Gate::allows('sys_admin')) {
            abort(403);
        }
    }

    public function edit(role $role)
    {
        if (!Gate::allows('sys_admin')) {
            abort(403);
        }
        return view('referensi.role.update', [
            'data' => $role,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function update(Request $request, role $role)
    {
        if (!Gate::allows('sys_admin')) {
            abort(403);
        }

        $request->validate([
            'koderole' => 'required|min:2|max:2',
            'role' => 'required'
        ]);

        $request->validate([
            'koderole' => 'numeric',
        ]);

        $role->update([
            'koderole' => $request->koderole,
            'role' => $request->role
        ]);

        return Redirect('/role')->with('berhasil', 'Data Berhasil Diubah');
    }

    public function destroy(role $role)
    {
        if (!Gate::allows('sys_admin')) {
            abort(403);
        }

        $role->delete();
        return Redirect('/role');
    }
}
