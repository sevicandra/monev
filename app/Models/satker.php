<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class satker extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'kodesatker',
        'kodesatkerkoordinator',
        'namasatker',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'satker', 'kodesatker');
    }

    public function unit()
    {
        return $this->hasMany(unit::class, 'kodesatker', 'kodesatker');
    }

    public function pagu()
    {
        return $this->hasMany(pagu::class, 'kodesatker', 'kodesatker')->where('tahun', session()->get('tahun'));
    }

    public function tagihan()
    {
        return $this->hasMany(tagihan::class, 'kodesatker', 'kodesatker')->where('tahun', session()->get('tahun'));
    }

    public function realisasi()
    {
        return $this->hasManyThrough(realisasi::class, tagihan::class, 'kodesatker', 'tagihan_id', 'kodesatker', 'id')
            ->where('tagihans.tahun', session()->get('tahun'))
            ->whereNotNull('tagihans.nomor_sp2d')
            ->whereNotNull('tagihans.tanggal_sp2d')
            ->whereNotNull('tagihans.no_spm')
        ;
    }

    public function sspb()
    {
        return $this->hasManyThrough(sspb::class, tagihan::class, 'kodesatker', 'tagihan_id', 'kodesatker', 'id')
            ->where('tagihans.tahun', session()->get('tahun'))
            ->whereNotNull('tagihans.nomor_sp2d')
            ->whereNotNull('tagihans.tanggal_sp2d')
            ->whereNotNull('tagihans.no_spm')
        ;
    }
    public function scopeSearch($data)
    {
        if (request('search')) {

            return $data->where('kodesatker', 'like', '%' . request('search') . '%')
                ->orwhere('namasatker', 'like', '%' . request('search') . '%');
        }
    }
}
