<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Support\Facades\DB;
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
        return $this->orderby('program')->orderby('kegiatan')->orderby('kro')->orderby('ro')->orderby('komponen')->orderby('subkomponen')->orderby('akun');
    }

    public function unit()
    {
        return $this->belongsTo(unit::class, 'kodeunit', 'id');
    }

    public function scopePagusatker()
    {
        return $this->where('tahun', session()->get('tahun'))->where('kodesatker', auth()->user()->satker);
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

    public function scopePagustafppk($data )
    {
        if (Gate::allows('Staf_PPK', auth()->user()->id)) {
            return $data->whereHas('unit', function($val){
                $val->stafppk();
            });
        }
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

    public function scopeJenisbelanja($data, $jenis)
    {
        return $data->whereRaw(DB::raw('left(akun, 2) = "'.$jenis.'"'));
    }
    
    public function scopeSearchprogram($data)
    {
        if (request('program')) {
            return $data->where('program', 'like', '%'.request('program').'%');
        }
    }

    public function scopeSearchkegiatan($data)
    {
        if (request('kegiatan')) {
            return $data->where('kegiatan', 'like', '%'.request('kegiatan').'%');
        }
    }

    public function scopeSearchkro($data)
    {
        if (request('kro')) {
            return $data->where('kro', 'like', '%'.request('kro').'%');
        }
    }

    public function scopeSearchro($data)
    {
        if (request('ro')) {
            return $data->where('ro', 'like', '%'.request('ro').'%');
        }
    }

    public function scopeSearchkomponen($data)
    {
        if (request('komponen')) {
            return $data->where('komponen', 'like', '%'.request('komponen').'%');
        }
    }

    public function scopeSearchsubkomponen($data)
    {
        if (request('subkomponen')) {
            return $data->where('subkomponen', 'like', '%'.request('subkomponen').'%');
        }
    }

    public function scopeSearchakun($data)
    {
        if (request('akun')) {
            return $data->where('akun', 'like', '%'.request('akun').'%');
        }
    }
}
