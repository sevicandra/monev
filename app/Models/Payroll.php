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
        return  $data   ->where('payrolls.status', 0)
                        ->where('tagihans.status', 4)
                        ->where('tagihans.kodesatker', auth()->user()->satker)
                        ->leftJoin('tagihans', 'payrolls.tagihan_id', '=', 'tagihans.id')
                        ->leftJoin('units', 'tagihans.kodeunit', '=', 'units.kodeunit')
                        ->leftJoin('users', 'tagihans.ppk_id', '=', 'users.nip')
                        ->leftJoin('realisasis', 'tagihans.id', '=', 'realisasis.tagihan_id')
                        ->groupBy('payrolls.tagihan_id')
                        ->selectRaw('tagihans.*, namaunit, users.nama as ppk, sum(realisasis.realisasi) as realisasi, sum(bruto) as payroll')
        ;
    }
}
