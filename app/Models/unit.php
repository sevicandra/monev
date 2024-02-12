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

    public function scopeMyunit()
    {
        return $this->where('kodesatker', auth()->user()->satker)->orderby('kodeunit');
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
        return $this->belongsToMany(User::class, 'verifikatorunits', 'unit_id', 'user_id', 'kodeunit', 'nip');
    }

    public function pagu()
    {
        return $this->hasMany(pagu::class,'kodeunit', 'kodeunit')->where('tahun', session()->get('tahun'));
    }

    public function realisasi()
    {
        $realisasi= realisasi::join('pagus', 'pagus.id', '=', 'realisasis.pagu_id')->where('tahun', session()->get('tahun'))->sp2d()
        ->join('units', 'pagus.kodeunit', '=', 'units.kodeunit')->where('units.kodeunit', $this->kodeunit);

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
        ->join('units', 'pagus.kodeunit', '=', 'units.kodeunit')->where('units.kodeunit', $this->kodeunit);

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

    public function stafppk()
    {
        return $this->belongsToMany(RefStafPPK::class, 'mapingunitstafppks', 'unit_id', 'user_id', 'kodeunit', 'nip')->where('satker', $this->satker);
    }

    public function stafppks()
    {
        return $this->belongsToMany(RefStafPPK::class, 'mapingunitstafppks', 'unit_id', 'user_id', 'kodeunit', 'nip');
    }

    public function scopeStafppk($data)
    {
        return $data->whereHas('stafppks', function($val){
            $val->where('nip', auth()->user()->nip)->where('satker', auth()->user()->satker);
        });
    }

    public function scopeNotStaf($data, $nip)
    {
        $var = $nip;
        return $data->whereDoesntHave('stafppks', function ($query) use ($var) {
            $query->where('nip', $var);
        });
    }
}
