<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pagu extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'program',
        'kegiatan',
        'kro',
        'ro',
        'komponen',
        'subkomponen',
        'akun',
        'anggaran',
        'kodesatker',
        'kodeunit',
        'tahun',
    ];

    public function scopeOrder(){
        return $this->orderby('program')->orderby('kegiatan')->orderby('kro')->orderby('ro')->orderby('komponen')->orderby('subkomponen')->orderby('akun')->get();
    }

    public function unit()
    {
        return $this->belongsTo(unit::class, 'kodeunit', 'id');
    }

    public function scopePagusatker()
    {
        return $this->where('kodesatker', auth()->user()->satker);
    }

    public function realisasi()
    {
        return $this->hasMany(realisasi::class);
    }

    public function sspb()
    {
        return $this->hasMany(sspb::class);
    }
}
