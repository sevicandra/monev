<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RefPPK extends Model
{
    use HasFactory, Uuids;

    protected $table = 'ref_ppks';

    protected $fillable = [
        'nama',
        'nip',
        'satker',
    ];
    public function paguppk()
    {
        return $this->belongsToMany(pagu::class, 'mapingpaguppks', 'user_id', 'pagu_id', 'nip', 'id')->where('tahun', session()->get('tahun'));
    }

    public function tagihan()
    {
        return $this->hasMany(tagihan::class, 'ppk_id', 'nip')->where('tahun', session()->get('tahun'));
    }

    public function realisasippk()
    {
        $realisasi= realisasi::join('pagus', 'pagus.id', '=', 'realisasis.pagu_id')->where('tahun', session()->get('tahun'))->join('mapingpaguppks', 'pagus.id', '=', 'mapingpaguppks.pagu_id')->sp2d()
        ->join('ref_ppks', 'mapingpaguppks.user_id', '=', 'ref_ppks.nip')->leftjoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')->where('ref_ppks.nip', $this->nip);
        if ($realisasi->first()) {
            return $realisasi;
        }
        $real = new Collection();

        $real->push((object)['realisasi' => '0',
        ]);

        return $real;
    }

    public function sspbppk()
    {
        $sspb = sspb::join('pagus', 'pagus.id', '=', 'sspbs.pagu_id')->where('tahun', session()->get('tahun'))->join('mapingpaguppks', 'pagus.id', '=', 'mapingpaguppks.pagu_id')
            ->join('ref_ppks', 'mapingpaguppks.user_id', '=', 'ref_ppks.nip')->where('ref_ppks.nip', $this->nip);

        if ($sspb->first()) {
            return $sspb;
        }
        $real = new Collection();

        $real->push((object)[
            'nominal_sspb' => '0',
        ]);

        return $real;
    }

    public function scopePPKsatker($data)
    {
        return $data->where('satker', auth()->user()->satker);
    }

    public function scopeSearch($data)
    {
        if (request('search')) {
            return $data->where('nama', 'like', '%' . request('search') . '%')
                ->orwhere('nip', 'like', '%' . request('search') . '%');
        }
    }

    public function stafppk()
    {
        return $this->belongsToMany(RefStafPPK::class, 'mapingstafppks', 'ppk_id', 'staf_id', 'nip', 'nip')->where('satker', $this->satker);
    }

    public function stafppks()
    {
        return $this->belongsToMany(RefStafPPK::class, 'mapingstafppks', 'ppk_id', 'staf_id', 'nip', 'nip');
    }

    public function scopeStafppk($data)
    {
        return $data->whereHas('stafppks', function ($val) {
            $val->where('nip', auth()->user()->nip)->where('satker', auth()->user()->satker);
        });
    }

    public function scopeNotPPK($data, $nip)
    {
        $var = $nip;
        return $data->whereDoesntHave('stafppks', function ($query) use ($var) {
            $query->where('nip', $var);
        });
    }
}
