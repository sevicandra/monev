<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'ppk_id'
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

    public function register()
    {
        return $this->hasOne(register_tagihan::class);
    }

    public function scopeNotregistered($data)
    {
        return $data->where('status', 1)->doesntHave('register');
    }

    public function scopeUnverified($data)
    {
        return $data->where('status', 2);
    }

    public function scopePpspm($data)
    {
        return $data->where('status', 3);
    }

    public function scopeBendahara($data)
    {
        return $data->where('status', 4);
    }

    public function scopeArsip($data)
    {
        return $data->where('status', 5);
    }

    public function spm()
    {
        return $this->hasOne(spm::class);
    }

    public function scopeTagihanppk($data)
    {
        if (Gate::allows('PPK', auth()->user()->id)) {
            return $data->where('ppk_id', auth()->user()->id);
        }

        if (Gate::allows('Staf_PPK', auth()->user()->id)) {
            return $data->where('ppk_id', auth()->user()->mapingstafppk->ppk_id);
        }
    }

    public function scopeTagihanverifikator($data)
    {
        return $data->wherehas('unit', function($val){
            $val->wherehas('verifikator', function($val){
                $val->where('id', auth()->user()->id);
            });
        });
    }

    public function scopeTagihansatker($data)
    {
        return $data->where('kodesatker', auth()->user()->satker)->where('tahun', session()->get('tahun'));
    }

    public function log()
    {
        return $this->hasMany(logtagihan::class);
    }

    public function rekanan()
    {
        return $this->belongsToMany(rekanan::class,'rekanantagihan');
    }

    public function scopeSearch($data)
    {
        if (request('search')) {
            return $data->where('notagihan', 'like', '%'.request('search').'%');
        }
    }
}