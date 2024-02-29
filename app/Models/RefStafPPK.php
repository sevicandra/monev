<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RefStafPPK extends Model
{
    use HasFactory, Uuids;
    protected $table = 'ref_staf_ppks';

    protected $fillable = ['nama', 'nip', 'satker', 'satgasBLBI'];

    public function scopeSearch($data)
    {
        if (request('search')) {
            return $data->where('nama', 'like', '%' . request('search') . '%')->orwhere('nip', 'like', '%' . request('search') . '%');
        }
    }

    public function ppk()
    {
        return $this->belongsToMany(RefPPK::class, 'mapingstafppks', 'staf_id', 'ppk_id', 'nip', 'nip')->where('satker', $this->satker);
    }

    public function ppks()
    {
        return $this->belongsToMany(RefPPK::class, 'mapingstafppks', 'staf_id', 'ppk_id', 'nip', 'nip');
    }

    public function scopeGetPPK()
    {
        return $this->where([
            'nip'=>auth()->user()->nip,
            'satker'=>session()->get('kdsatker')
        ])->first()->ppk()->pluck('nip')->toArray();
    }

    public function scopeNotStaf($data, $nip)
    {
        $var = $nip;
        return $data->whereDoesntHave('ppks', function ($query) use ($var) {
            $query->where('nip', $var);
        });
    }

    public function scopeSatker($data)
    {
        return $data->where('satker', session()->get('kdsatker'));
    }

    public function unit()
    {
        return $this->belongsToMany(unit::class, 'mapingunitstafppks', 'user_id', 'unit_id', 'nip', 'kodeunit')->where('kodesatker', $this->satker);
    }

    public function units()
    {
        return $this->belongsToMany(unit::class, 'mapingunitstafppks', 'user_id', 'unit_id', 'nip', 'kodeunit');
    }

    public function scopeGetUnit()
    {
        return $this->where([
            'nip'=>auth()->user()->nip,
            'satker'=>session()->get('kdsatker')
        ])->first()->unit()->pluck('kodeunit')->toArray();
    }

    public function scopeNotUnit($data, $nip)
    {
        $var = $nip;
        return $data->whereDoesntHave('units', function ($query) use ($var) {
            $query->where('nip', $var);
        });
    }

}
