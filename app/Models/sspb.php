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
        'pagu_id'
    ];

    public function pagu()
    {
        return $this->belongsTo(pagu::class);
    }

    public function realisasi()
    {
        return $this->belongsTo(realisasi::class);
    }
}
