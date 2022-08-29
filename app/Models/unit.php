<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
