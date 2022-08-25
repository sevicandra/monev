<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function ppk()
    {
        return $this->belongsToMany(User::class, 'mapingpaguppks');
    }

    public function mapingppk()
    {
        return $this->hasOne(mapingpaguppk::class);
    }

    public function scopePagunonppk($data)
    {
        return $data->doesntHave('ppk');
    }

    public function scopePaguppk($data)
    {
        return $data->wherehas('ppk', function($val){
            if (Gate::allows('PPK', auth()->user()->id)) {
                return $val->where('user_id', auth()->user()->id);
            }
    
            if (Gate::allows('Staf_PPK', auth()->user()->id)) {
                return $val->where('user_id', auth()->user()->mapingstafppk->ppk_id);
            }
        });
    }

    
}
