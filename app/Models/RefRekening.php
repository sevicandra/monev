<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefRekening extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'kode',
        'nama',
        'bank',
        'otherbank',
        'norek',
        'kdsatker'
    ];

    public function scopeSearch($data)
    {
        if(request('search')){
            $data = $data->where('kode','like','%'.request('search').'%')
            ->orWhere('nama','like','%'.request('search').'%')
            ->orWhere('bank','like','%'.request('search').'%')
            ->orWhere('otherbank','like','%'.request('search').'%')
            ->orWhere('norek','like','%'.request('search').'%')
            ->orWhere('kdsatker','like','%'.request('search').'%');
        }
        return $data;
    }
}
