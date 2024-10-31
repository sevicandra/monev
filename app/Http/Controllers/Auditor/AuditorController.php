<?php

namespace App\Http\Controllers\Auditor;

use App\Models\spm;
use App\Models\satker;
use App\Models\tagihan;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

class AuditorController extends Controller
{

    public function index()
    {
        if (!Gate::any(['auditor'])) {
            abort(403);
        }
        return view('audit.index', [
            'data' => satker::with(['pagu', 'realisasi' => function ($realisasi) {
                $realisasi->whereHas('spm')->join('pagus', 'pagus.id', '=', 'realisasis.pagu_id')
                    ->groupByRaw('left(pagus.akun, 2)')
                    ->selectRaw('sum(realisasi) as realisasi, left(pagus.akun, 2) as jenis_belanja')
                ;
            }, 'sspb' => function ($sspb) {
                $sspb->whereHas('spm')->join('pagus', 'pagus.id', '=', 'sspbs.pagu_id')
                    ->groupByRaw('left(pagus.akun, 2)')
                    ->selectRaw('sum(nominal_sspb) as nominal_sspb, left(pagus.akun, 2) as  jenis_belanja')

                ;
            }])->get(),
        ]);
    }

    public function detail($kdSatker)
    {
        if (!Gate::any(['auditor'])) {
            abort(403);
        }
        return view('audit.detail', [
            'data' => spm::with('realisasi')->where('kd_satker', $kdSatker)
                ->search()
                ->where('tahun', session()->get('tahun'))
                ->order()
                ->paginate(15)->withQueryString(),
        ]);
    }

    public function rincian($kdSatker, $nomorSp2d)
    {
        if (!Gate::any(['auditor'])) {
            abort(403);
        }

        $data = tagihan::tagihansatker()->whereHas('spm', function ($q) use ($nomorSp2d) {
            $q->where('nomor_sp2d', $nomorSp2d);
        })->search()->with('realisasi')->order()->paginate(15)->withQueryString();
        if ($data == null) {
            abort(404);
        }
        return view('audit.rincian', [
            'data' => $data,
            'kdSatker' => $kdSatker,
        ]);
    }

    public function coa(tagihan $tagihan)
    {
        if (!Gate::any(['auditor'])) {
            abort(403);
        }

        if ($tagihan->spm == null || $tagihan->tahun != session()->get('tahun')) {
            abort(404);
        }

        return view('audit.coa', [
            'data' => $tagihan->realisasi()->with('pagu')->get(),
            'tagihan' => $tagihan,
            'spm' => $tagihan->spm
        ]);
    }

    public function dokumen(tagihan $tagihan)
    {
        if (!Gate::any(['auditor'])) {
            abort(403);
        }
        
        if ($tagihan->spm == null || $tagihan->tahun != session()->get('tahun')) {
            abort(404);
        }

        return view('audit.dokumen', [
            'data' => $tagihan->berkasupload()->whereNot('berkas_id', '05')->get(),
            'tagihan' => $tagihan,
            'spm' => $tagihan->spm
        ]);
    }
}
