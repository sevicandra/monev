<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dokumen extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'kodedokumen',
        'namadokumen',
        'statusdnp',
        'statuspph',
        'statusrekanan',
        'dnp_perjadin',
        'dnp_honor',
        'blbi',
    ];


    public function scopeNotBLBI($data)
    {
        return $data    ->where('blbi', false);
    }

    public function scopeBLBI($data)
    {
        return $data    ->where('blbi', true);
    }
}
