<?php

namespace App\Http\Controllers;

use App\Models\tarifPpn;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ReferensiTarifPpnController extends Controller
{
    public function index()
    {
        if (!Gate::allows('sys_admin')) {
            abort(403);
        }
        $tarifPpn = tarifPpn::orderBy('tarif')->paginate(15)->withQueryString();
        return view('referensi.tarifppn.index', [
            'data' => $tarifPpn
        ]);
    }

    public function create()
    {
        if (!Gate::allows('sys_admin')) {
            abort(403);
        }
        return view('referensi.tarifppn.create');
    }

    public function store(Request $request)
    {
        if (!Gate::allows('sys_admin')) {
            abort(403);
        }
        $request->validate([
            'tarif' => 'required|numeric|min:0|max:100',
        ]);

        $tarifPpn = new tarifPpn();
        $tarifPpn->tarif = $request->tarif;
        $tarifPpn->save();

        return redirect('/referensi/tarif-ppn')->with('berhasil', 'Tarif PPN berhasil ditambahkan');
    }

    public function edit(tarifPpn $ppn)
    {
        if (!Gate::allows('sys_admin')) {
            abort(403);
        }
        return view('referensi.tarifppn.update', [
            'data' => $ppn
        ]);
    }

    public function update(Request $request, tarifPpn $ppn)
    {
        
        if (!Gate::allows('sys_admin')) {
            abort(403);
        }
        $request->validate([
            'tarif' => 'required|numeric|min:0|max:100',
        ]);

        $ppn->tarif = $request->tarif;
        $ppn->save();

        return redirect('/referensi/tarif-ppn')->with('berhasil', 'Tarif PPN berhasil diperbarui');
    }

    public function destroy(tarifPpn $ppn)
    {
        if (!Gate::allows('sys_admin')) {
            abort(403);
        }
        $ppn->delete();

        return redirect('/referensi/tarif-ppn')->with('berhasil', 'Tarif PPN berhasil dihapus');
    }
}