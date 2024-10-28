<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class realisasi extends Model
{
    use Uuids;
    use HasFactory;
    protected $fillable = [
        'pagu_id',
        'tagihan_id',
        'realisasi',
    ];

    public function tagihan()
    {
        return $this->belongsTo(tagihan::class);
    }

    public function pagu()
    {
        return $this->belongsTo(pagu::class);
    }

    public function sspb()
    {
        return $this->hasMany(sspb::class);
    }

    public function spm()
    {
        return $this->hasOneThrough(spm::class, tagihan::class, 'id', 'id', 'tagihan_id', 'spm_id');
    }

    public function scopeRealisaijenisbelanja($data, $jenis)
    {
        $a = $jenis;
        return $data->wherehas('pagu', function ($val) use ($a) {
            $val->where('tahun', session()->get('tahun'))->where('kodesatker', session()->get('kdsatker'))->whereRaw('left(akun, 2) =' . $a);
        })->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')->groupBy('realisasis.id')->selectRaw('realisasis.*, sum(sspbs.nominal_sspb) as nominal_sspb');
    }

    public function scopeSp2d($data)
    {
        if (request('sp2d') === 'ya') {
            return $data->wherehas('tagihan', function ($val) {
                $val->wherehas('spm');
            });
        }
        return $data;
    }

    public function scopeSpm($data)
    {
        return $data->wherehas('tagihan', function ($val) {
            $val->where('no_spm', '!=', null);
        })->join('pagus', 'pagus.id', '=', 'realisasis.pagu_id')->join('tagihans', 'tagihans.id', '=', 'realisasis.tagihan_id')
            ->selectRaw('pagus.program, pagus.kegiatan, pagus.kro, pagus.akun, realisasis.realisasi')
        ;
        return $data;
    }

    public function scopeSearchprogram($data)
    {
        if (request('program')) {
            return $data->wherehas('pagu', function ($val) {
                $val->where('program', 'like', '%' . request('program') . '%');
            });
        }
    }

    public function scopeSearchkegiatan($data)
    {
        if (request('kegiatan')) {
            return $data->wherehas('pagu', function ($val) {
                $val->where('kegiatan', 'like', '%' . request('kegiatan') . '%');
            });
        }
    }

    public function scopeSearchkro($data)
    {
        if (request('kro')) {
            return $data->wherehas('pagu', function ($val) {
                $val->where('kro', 'like', '%' . request('kro') . '%');
            });
        }
    }

    public function scopeSearchro($data)
    {
        if (request('ro')) {
            return $data->wherehas('pagu', function ($val) {
                $val->where('ro', 'like', '%' . request('ro') . '%');
            });
        }
    }

    public function scopeSearchkomponen($data)
    {
        if (request('komponen')) {
            return $data->wherehas('pagu', function ($val) {
                $val->where('komponen', 'like', '%' . request('komponen') . '%');
            });
        }
    }

    public function scopeSearchsubkomponen($data)
    {
        if (request('subkomponen')) {
            return $data->wherehas('pagu', function ($val) {
                $val->where('subkomponen', 'like', '%' . request('subkomponen') . '%');
            });
        }
    }

    public function scopeSearchakun($data)
    {
        if (request('akun')) {
            return $data->wherehas('pagu', function ($val) {
                $val->where('akun', 'like', '%' . request('akun') . '%');
            });
        }
    }
}
