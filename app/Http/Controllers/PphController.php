<?php

namespace App\Http\Controllers;

use App\Models\pph;
use App\Helper\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PphController extends Controller
{
    public function index()
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.pph.index',[
            'data'=>pph::orderby('kodegolongan', 'DESC')->get(),
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function create()
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.pph.create',[
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function store(Request $request)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $request->validate([
            'kodegolongan'=>'required|unique:pphs|min:1|max:1',
            'tarifpph'=>'required|numeric'
        ]);

        $request->validate([
            'kodegolongan'=>'numeric',
        ]);

        pph::create([
            'kodegolongan'=>$request->kodegolongan,
            'tarifpph'=>$request->tarifpph
        ]);
        return redirect('/pph');
    }

    public function edit(pph $pph)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        return view('referensi.pph.update',[
            'data'=>$pph,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function update(Request $request, pph $pph)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $request->validate([
            'kodegolongan'=>'required|min:1|max:1',
            'tarifpph'=>'required|numeric'
        ]);

        $request->validate([
            'kodegolongan'=>'numeric',
        ]);

        $pph->update([
            'kodegolongan'=>$request->kodegolongan,
            'tarifpph'=>$request->tarifpph
        ]);
        return redirect('/pph');
    }

    public function destroy(pph $pph)
    {
        if (! Gate::allows('sys_admin', auth()->user()->id)) {
            abort(403);
        }
        $pph->delete();
        return redirect('/pph');
    }
}
