<?php

namespace App\Http\Controllers;

use App\Models\tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class CleansingSpmController extends Controller
{
    public function update(){
        if (!Gate::any(['sys_admin', 'admin_satker'])) {
            abort(403);
        }
        $data = tagihan::where('tahun', session()->get('tahun'))->wherehas('spm')->get();

        foreach ($data as $item) {
            if ($item->tanggal_spm != null) {
                continue;
            }
            $spm = $item->spm()->first();
            $item->where('id', $item->id)->update([
                'tanggal_spm'=>$spm->tanggal_spm,
                'tanggal_sp2d'=>$spm->tanggal_sp2d,
                'nomor_sp2d'=>$spm->nomor_sp2d
            ]);
        }
    }
}
