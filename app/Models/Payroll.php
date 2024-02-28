<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payroll extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'tagihan_id',
        'nama',
        'bank',
        'norek',
        'bruto',
        'pajak',
        'admin',
        'netto',
    ];

    public function tagihan()
    {
        return $this->belongsTo(Tagihan::class);
    }

    public function scopeBelumTransfer($data)
    {
        return  $data->where('payrolls.status', 0)
            ->where('tagihans.status', 4)
            ->where('tagihans.kodesatker', auth()->user()->satker)
            ->leftJoin('tagihans', 'payrolls.tagihan_id', '=', 'tagihans.id')
            ->leftJoin('units', 'tagihans.kodeunit', '=', 'units.kodeunit')
            ->leftJoin('ref_ppks', 'tagihans.ppk_id', '=', 'ref_ppks.nip')
            ->leftJoin('realisasis', 'tagihans.id', '=', 'realisasis.tagihan_id')
            ->where('tagihans.tahun', session()->get('tahun'))
            ->groupBy('payrolls.tagihan_id')
            ->orderBy('tagihans.updated_at', 'asc')
            ->selectRaw('tagihans.*, namaunit, ref_ppks.nama as ppk, avg(realisasis.realisasi) as realisasi, sum(bruto) as payroll');
    }

    public function scopeBelumTransferCount()
    {
        return $this->where('payrolls.status', 0)
            ->whereHas('tagihan', function ($q) {
                $q->where('tagihans.status', 4)
                    ->where('tagihans.kodesatker', auth()->user()->satker)
                    ->where('tagihans.tahun', session()->get('tahun'));
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

    public function scopeFilterJenis($data)
    {
        if (request('jnstagihan')) {
            return $data->where('jnstagihan', request('jnstagihan'));
        }
    }
}
