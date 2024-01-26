<?php

namespace App\Http\Controllers;

use App\Models\satker;
use App\Helper\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SatkerController extends Controller
{

    public function index()
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.satker.index',[
            'data'=>satker::search()->paginate(15)->withQueryString(),
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function create()
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.satker.create',[
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function store(Request $request)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        if ($request['kodesatkerkoordinator'] != null) {
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

    public function show(satker $satker)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        //
    }

    public function edit(satker $satker)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.satker.update',[
            'data'=> $satker,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function update(Request $request, satker $satker)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        if ($request['kodesatkerkoordinator'] != null) {
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

    public function destroy(satker $satker)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $satker->delete();
        return redirect('/satker');
    }
}
