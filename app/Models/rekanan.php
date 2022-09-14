<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class rekanan extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'npwp',
        'kodesatker',
        'nama',
        'idpajak'
    ];

    public function tagihan()
    {
        return $this->belongsToMany(tagihan::class,'rekanantagihan');
    }

    public function scopeOfTagihan($data, $tagihan)
    {

        $var = $tagihan;
        return $data->whereDoesntHave('tagihan', function($val)use($var){
            $val->where('id', $var);
        })->get();
    }

    public function scopeRekanansatker($data)
    {
        return $data->where('kodesatker', auth()->user()->satker);
    }

    public function scopeSearch($data)
    {
        if (request('search')) {
            return $data    ->where('nama', 'like', '%'.request('search').'%')
                            ->orwhere('idpajak', 'like', '%'.request('search').'%');
        }
    }
}
