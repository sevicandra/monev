<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class unit extends Model
{
    use Uuids;
    use HasFactory;
    
    protected $fillable = [
        'kodeunit',
        'kodesatker',
        'namaunit',
    ];


    public function satker()
    {
        return $this->belongsTo(satker::class, 'kodesatker', 'kodesatker');
    }

    public function stafppk()
    {
        return $this->belongsToMany(User::class, 'mapingunitstafppks');
    }

    public function scopeMyunit()
    {
        return $this->where('kodesatker', auth()->user()->satker)->orderby('kodeunit');
    }

    public function scopeStafppk()
    {
        return $this->whereHas('stafppk', function($val){
            $val->where('nip', auth()->user()->nip);
        });
    }

    public function scopeNostafppk($data, $stafppk)
    {
        $var=$stafppk;
        return $data->whereDoesntHave('stafppk', function($val)use($var){
            $val->where('nip', $var);
        });
    }

    public function verifikator()
    {
        return $this->belongsToMany(User::class, 'verifikatorunits');
    }

    public function pagu()
    {
        return $this->hasMany(pagu::class,'kodeunit')->where('tahun', session()->get('tahun'));
    }

    public function realisasi()
    {
        $realisasi= realisasi::join('pagus', 'pagus.id', '=', 'realisasis.pagu_id')->where('tahun', session()->get('tahun'))->sp2d()
        ->join('units', 'pagus.kodeunit', '=', 'units.id')->where('units.id', $this->id);

        if ($realisasi->first()) {
            return $realisasi;
        }
        $real = new Collection();
        
        $real->push((object)['realisasi' => '0',
        ]);

        return $real;
    }

    public function sspb()
    {
        $sspb= sspb::join('pagus', 'pagus.id', '=', 'sspbs.pagu_id')->where('tahun', session()->get('tahun'))
        ->join('units', 'pagus.kodeunit', '=', 'units.id')->where('units.id', $this->id);

        if ($sspb->first()) {
            return $sspb;
        }
        $real = new Collection();
        
        $real->push((object)['nominal_sspb' => '0',
        ]);

        return $real;
    }

    public function scopeSearch($data)
    {
        if (request('search')) {
            return $data->where('namaunit', 'like', '%'.request('search').'%');
        }
    }
}
