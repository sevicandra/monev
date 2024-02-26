<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DnpPerjadin extends Model
{
    use HasFactory, Uuids;

    protected $fillable = [
        'tagihan_id',
        'nama',
        'nip',
        'unit',
        'st',
        'lokasi',
        'durasi',
        'norek',
        'namarek',
        'bank',
        'transport',
        'transportLain',
        'uangharian',
        'penginapan',
        'representatif',
    ];

    public function tagihan()
    {
        return $this->belongsTo(tagihan::class, 'tagihan_id', 'id');
    }

    public function rincian()
    {
        return $this->hasMany(RincianDNPPerjadin::class, 'dnp_id', 'id');
    }

    public function scopeTransport($data)
    {
        return $data->select('id', 'transport', 'transportLain');
    }

    public function scopeSearch($data)
    {
        if (request('search')) {
            return $data->where('nama', 'like', '%' . request('search') . '%')
                ->orwhere('nip', 'like', '%' . request('search') . '%');
        }
    }
}
