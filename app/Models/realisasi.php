<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class realisasi extends Model
{
    use Uuids;
    use HasFactory;
    protected $fillable = [
        'pagu_id',
        'tagihan_id',
        'realisasi',
    ];

    public function tagihan()
    {
        return $this->belongsTo(tagihan::class);
    }

    public function pagu()
    {
        return $this->belongsTo(pagu::class);
    }
}
