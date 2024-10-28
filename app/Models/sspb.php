<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sspb extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'realisasi_id',
        'tanggal_sspb',
        'nominal_sspb',
        'tagihan_id',
        'pagu_id',
        'ntpn',
    ];

    public function pagu()
    {
        return $this->belongsTo(pagu::class);
    }

    public function realisasi()
    {
        return $this->belongsTo(realisasi::class);
    }

    public function tagihan()
    {
        return $this->belongsTo(tagihan::class);
    }

    public function spm()
    {
        return $this->hasOneThrough(spm::class, tagihan::class, 'id', 'id', 'tagihan_id', 'spm_id');
    }
}
