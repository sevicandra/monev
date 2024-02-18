<?php

namespace App\Http\Controllers;

use App\Models\rekanan;
use App\Models\tagihan;
use App\Models\pphrekanan;
use App\Models\ppnrekanan;
use App\Helper\Notification;
use Illuminate\Http\Request;
use App\Models\register_tagihan;
use Illuminate\Support\Facades\Gate;

class MonitoringTagihanController extends Controller
{
    public function index()
    {
        if (!Gate::allows('PPK', auth()->user()->id) && !Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }

        if (Gate::allows('PPK', auth()->user()->id)) {
            $data = tagihan::tagihanppk()->where('tahun', session()->get('tahun'))->search()->order()->paginate(15)->withQueryString();
        } else {
            $data = tagihan::tagihansatker()->tagihanppk()->where('tahun', session()->get('tahun'))->search()->order()->paginate(15)->withQueryString();
        }
        return view('monitoring_tagihan.index', [
            'data' => $data,
            'notifikasi' => Notification::Notif()
        ]);
    }

    public function show(Request $request, tagihan $monitoring_tagihan)
    {
        if (!Gate::allows('PPK', auth()->user()->id) && !Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }

        if (Gate::allows('PPK', auth()->user()->id)) {
            if ($monitoring_tagihan->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK', auth()->user()->id)) {
            if (!in_array($monitoring_tagihan->ppk_id, session()->get('ppk')) || !in_array($monitoring_tagihan->kodeunit, session()->get('unit')) || $monitoring_tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        }
        switch ($request->scope) {
            case 'dokumen':
                return view('monitoring_tagihan.dokumen', [
                    'data' => $monitoring_tagihan->berkasupload,
                    'notifikasi' => Notification::Notif()
                ]);
                break;

            case 'histories':
                return view('monitoring_tagihan.detail', [
                    'data' => $monitoring_tagihan->log()->orderBy('created_at', 'desc')->get(),
                    'notifikasi' => Notification::Notif()
                ]);
                break;
        }
    }

    public function showcoa(tagihan $tagihan)
    {
        if (!Gate::allows('PPK', auth()->user()->id) && !Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }

        if (Gate::allows('PPK', auth()->user()->id)) {
            if ($tagihan->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK', auth()->user()->id)) {
            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        }

        return view('monitoring_tagihan.coa', [
            'data' => $tagihan->realisasi()->searchprogram()
                ->searchkegiatan()
                ->searchkro()
                ->searchro()
                ->searchkomponen()
                ->searchsubkomponen()
                ->searchakun()->paginate(15)->withQueryString(),
            'notifikasi' => Notification::Notif()
        ]);
    }

    // public function showdnp(tagihan $tagihan)
    // {
    //     if (! Gate::allows('PPK', auth()->user()->id)&&! Gate::allows('Staf_PPK', auth()->user()->id)) {
    //         abort(403);
    //     }

    //     if (Gate::allows('PPK', auth()->user()->id)) {
    //         if ($tagihan->ppk_id != auth()->user()->nip) {
    //             abort(403);
    //         }
    //     }

    //     if (Gate::allows('Staf_PPK', auth()->user()->id)) {
    //         if ($tagihan->ppk_id != auth()->user()->mapingstafppk->ppk_id) {
    //             abort(403);
    //         }
    //     }
    //     return view('monitoring_tagihan.dnp',[
    //         'data'=>$tagihan->dnp()->search()->paginate(15)->withQueryString(),
    //         'tagihan'=>$tagihan
    //     ]);
    // }

    public function showrekanan(tagihan $tagihan)
    {
        if (!Gate::allows('PPK', auth()->user()->id) && !Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }

        if (Gate::allows('PPK', auth()->user()->id)) {
            if ($tagihan->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK', auth()->user()->id)) {
            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        }
        return view('monitoring_tagihan.rekanan.index', [
            'data' => $tagihan->rekanan()->rekanansatker()->search()->paginate(15)->withQueryString(),
            'tagihan' => $tagihan,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function showppnrekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (!Gate::allows('PPK', auth()->user()->id) && !Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }

        if (Gate::allows('PPK', auth()->user()->id)) {
            if ($tagihan->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK', auth()->user()->id)) {
            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        }
        return view('monitoring_tagihan.rekanan.ppn.index', [
            'data' => ppnrekanan::myppn($tagihan, $rekanan)->get(),
            'tagihan' => $tagihan,
            'rekanan' => $rekanan,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function showpphrekanan(tagihan $tagihan, rekanan $rekanan)
    {
        if (!Gate::allows('PPK', auth()->user()->id) && !Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }

        if (Gate::allows('PPK', auth()->user()->id)) {
            if ($tagihan->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK', auth()->user()->id)) {
            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        }
        return view('monitoring_tagihan.rekanan.pph.index', [
            'data' => pphrekanan::mypph($tagihan, $rekanan)->get(),
            'tagihan' => $tagihan,
            'rekanan' => $rekanan,
            'notifikasi'=>Notification::Notif()
        ]);
    }

    public function tolak(tagihan $tagihan)
    {
        if (!Gate::allows('PPK', auth()->user()->id) && !Gate::allows('Staf_PPK', auth()->user()->id)) {
            abort(403);
        }

        if ($tagihan->status != 1) {
            return abort(403);
        }

        if (Gate::allows('PPK', auth()->user()->id)) {
            if ($tagihan->ppk_id != auth()->user()->nip) {
                abort(403);
            }
        }

        if (Gate::allows('Staf_PPK', auth()->user()->id)) {
            if (!in_array($tagihan->ppk_id, session()->get('ppk')) || !in_array($tagihan->kodeunit, session()->get('unit')) || $tagihan->kodesatker != auth()->user()->satker) {
                abort(403);
            }
        }

        $tagihan->update(['status' => 0]);
        register_tagihan::where('tagihan_id', $tagihan->id)->delete();
        return redirect('/monitoring-tagihan');
    }
}
