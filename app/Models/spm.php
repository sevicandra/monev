<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class spm extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'tagihan_id',
        'tanggal_spm',
        'nomor_sp2d',
        'tanggal_sp2d',
    ];

    public function tagihan()
    {
        return $this->belongsTo(tagihan::class);
    }
}
