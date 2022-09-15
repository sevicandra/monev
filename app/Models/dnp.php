<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class dnp extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'tagihan_id',
        'nip',
        'nama',
        'kodegolongan',
        'rekening',
        'namabank',
        'namarekening',
    ];

    public function tagihan()
    {
        return $this->belongsTo(tagihan::class);
    }

    public function pph()
    {
        return $this->belongsTo(pph::class, 'kodegolongan', 'kodegolongan');
    }

    public function nominal()
    {
        return $this->hasOne(nominaldnp::class);
    }

    public function scopeSearch($data)
    {
        if (request('search')) {
            return $data    ->where('nama', 'like', '%'.request('search').'%')
                            ->orwhere('nip', 'like', '%'.request('search').'%')
                            ->orwhere('namabank', 'like', '%'.request('search').'%')
            ;
        }
    }
}
