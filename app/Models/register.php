<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class register extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'tahun',
        'kodesatker',
        'ppk_id',
        'nomor',
        'ekstensi',
        'status',
        'file',
        'dokumen_id',
        'dokumen_date'
    ];

    public function register_tagihan()
    {
        return $this->hasMany(register_tagihan::class);
    }

    public function tagihan()
    {
        return $this->BelongsToMany(tagihan::class, register_tagihan::class);
    }

    public function scopeRegisterppk($data)
    {
        if (Gate::allows('PPK', auth()->user()->id)) {
            return $data->where('ppk_id', auth()->user()->nip);
        }

        if (Gate::allows('Staf_PPK', auth()->user()->id)) {
            return $data->where('ppk_id', auth()->user()->mapingstafppk->ppk_id);
        }
    }

    public function scopeSearch($data)
    {
        if (request('search')) {
            return $data->where('nomor', 'like', '%'.request('search').'%');
        }
    }

    public function ppk()
    {
        return $this->belongsTo(RefPPK::class, 'ppk_id', 'nip');
    }

    public function scopeArsip($data)
    {
        return $data->where('status', 1);
    }

    public function scopeOrder($data)
    {
        return $data->orderby('nomor');
    }
}
