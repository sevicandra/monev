<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;

class spm extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'nomor_spm',
        'tanggal_spm',
        'nomor_sp2d',
        'tanggal_sp2d',
        'tahun',
        'kd_satker',
        'jenis_spm',
        'deskripsi',
    ];

    public function tagihan()
    {
        return $this->hasMany(tagihan::class);
    }

    public function realisasi()
    {
        return $this->hasManyThrough(realisasi::class, tagihan::class);
    }

    public function scopeDuplicate()
    {
        $duplicate =  $this->select('tagihan_id')->groupBy('tagihan_id')->havingRaw('count(*) > 1');
        return $this->whereIn('spms.tagihan_id', $duplicate)
            ->join('tagihans', function (JoinClause $join) {
                $join->on('tagihans.id', '=', 'spms.tagihan_id')->where('tagihans.tahun',  session()->get('tahun'))->where('kodesatker', session()->get('kdsatker'));
            })->orderBy('tagihans.notagihan')
            ->orderBy('tagihans.jnstagihan')
            ->select(['spms.id', 'spms.tanggal_sp2d', 'tagihans.notagihan', 'spms.nomor_sp2d', 'tagihans.tgltagihan', 'tagihans.jnstagihan'])
        ;
    }

    public function scopeOrder($data)
    {
        switch (request('sb')) {
            case 'nomor_spm':
                $sb = 'nomor_spm';
                break;
            case 'tanggal_spm':
                $sb = 'tanggal_spm';
                break;
            case 'nomor_sp2d':
                $sb = 'nomor_sp2d';
                break;
            case 'tanggal_sp2d':
                $sb = 'tanggal_sp2d';
                break;
            default:
                $sb = 'nomor_spm';
                break;
        }

        switch (request('sd')) {
            case 'asc':
                $sd = 'asc';
                break;
            case 'desc':
                $sd = 'desc';
                break;
            default:
                $sd = 'desc';
                break;
        }
        return $data->orderBy($sb, $sd);
    }

    public function scopeSearch($data)
    {
        return $data->where(function ($query) {
            $query->where('nomor_spm', 'like', '%' . request('search') . '%')
                ->orWhere('nomor_sp2d', 'like', '%' . request('search') . '%');
        });
    }
}
