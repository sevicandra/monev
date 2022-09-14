<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pegawainondjkn extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'nip',
        'nama',
        'kodegolongan',
        'rekening',
        'namabank',
        'namarekening',
    ];

    public function scopeSearch($data)
    {
        if (request('search')) {
            return $data    ->where('nip', 'like', '%'.request('search').'%')
                            ->orwhere('nama', 'like', '%'.request('search').'%')
                            ->orwhere('namabank', 'like', '%'.request('search').'%');
        }
    }
}
