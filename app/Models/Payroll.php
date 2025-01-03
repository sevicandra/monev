<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory, Uuids;

    protected $fillable = ['tagihan_id', 'nama', 'bank', 'norek', 'bruto', 'pajak', 'admin', 'netto'];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }

    public function scopeBelumTransfer($data)
    {
        return $data->where('payrolls.status', 0)->where('tagihans.status', 4)->where('tagihans.kodesatker', session()->get('kdsatker'))->leftJoin('tagihans', 'payrolls.tagihan_id', '=', 'tagihans.id')->leftJoin('units', 'tagihans.kodeunit', '=', 'units.kodeunit')->leftJoin('ref_ppks', 'tagihans.ppk_id', '=', 'ref_ppks.nip')->leftJoin('realisasis', 'tagihans.id', '=', 'realisasis.tagihan_id')->where('tagihans.tahun', session()->get('tahun'))->groupBy('payrolls.tagihan_id')->orderBy('tagihans.updated_at', 'asc')->selectRaw('tagihans.*, namaunit, ref_ppks.nama as ppk, avg(realisasis.realisasi) as realisasi, sum(bruto) as payroll');
    }

    public function scopeBelumTransferCount()
    {
        return $this->where('payrolls.status', 0)
            ->whereHas('tagihan', function ($q) {
                $q->where('tagihans.status', 4)->where('tagihans.kodesatker', session()->get('kdsatker'))->where('tagihans.tahun', session()->get('tahun'));
            })
            ->groupBy('payrolls.tagihan_id')
            ->select('payrolls.tagihan_id')
            ->get();
    }

    public function scopeBelumApprove($data)
    {
        return $data->where('status', 0);
    }

    public function scopeSearch($data)
    {
        if (request('search')) {
            return $data->where('nama', 'like', '%' . request('search') . '%');
        }
    }

    public function scopeSearchTagihan($data)
    {
        if (request('search')) {
            return $data->where('notagihan', 'like', '%' . request('search') . '%');
        }
    }

    public function scopeFilter($data)
    {
        switch (request('jns')) {
            case 'SPBY':
                return $data->where('jnstagihan', 0);
            case 'SPP':
                return $data->where('jnstagihan', 1);
            default:
                return $data;
        }
    }

    public function scopeRekap()
    {
        if (request('search')) {
            $data = $this->where('norek', 'like', '%' . request('search') . '%')->orwhere('nama', 'like', '%' . request('search') . '%');
            return $data->whereHas('tagihan', function ($val) {
                $val->where('tahun', session()->get('tahun'));
            })
                ->orderBy('norek')
                ->groupBy('norek')
                ->selectRaw('nama, bank, norek, sum(bruto) as bruto, sum(pajak) as pajak, sum(admin) as admin, sum(netto) as netto');
        }else{
            return $this->whereHas('tagihan', function ($val) {
                $val->where('tahun', session()->get('tahun'));
            })
                ->orderBy('norek')
                ->groupBy('norek')
                ->selectRaw('nama, bank, norek, sum(bruto) as bruto, sum(pajak) as pajak, sum(admin) as admin, sum(netto) as netto');
        }

    }

    public function scopeTracking()
    {
        if (request('search')) {
            return $this->where('norek', request('search'))->whereHas('tagihan')->with(['tagihan'])->orderBy('created_at', 'desc');
                ;
        }else{
            return $this->where('norek', request('search'))
                ->limit(0);
        }

    }
}
