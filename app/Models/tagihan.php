<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tagihan extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'notagihan',
        'jnstagihan',
        'kodeunit',
        'kodedokumen',
        'status',
        'tgltagihan',
        'kodesatker',
        'tahun',
        'uraian',
    ];
    
    public function unit()
    {
        return $this->belongsTo(unit::class, 'kodeunit', 'id');
    }

    public function dokumen()
    {
        return $this->belongsTo(dokumen::class, 'kodedokumen', 'id');
    }

    public function berkasupload(){
        return $this->hasMany(berkasupload::class);
    }

    public function realisasi()
    {
        return $this->hasMany(realisasi::class);
    }

    public function dnp()
    {
        return $this->hasMany(dnp::class);
    }

    public function nominaldnp()
    {
        return $this->hasManyThrough(nominaldnp::class, dnp::class);
    }

}
