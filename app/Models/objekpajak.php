<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class objekpajak extends Model
{
    use Uuids;
    use HasFactory;
    protected $fillable = [
        'kode',
        'nama',
        'jenis',
        'tarif',
        'tarifnonnpwp',
    ];

    public function scopeSearch($data)
    {
        if (request('search')) {
            return $data    ->where('kode', 'like', '%'.request('search').'%')
                            ->orwhere('nama', 'like', '%'.request('search').'%')
                            ->orwhere('jenis', 'like', '%'.request('search').'%');
        }
    }
}
