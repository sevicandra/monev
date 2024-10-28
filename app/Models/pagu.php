<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class pagu extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = ['program', 'kegiatan', 'kro', 'ro', 'komponen', 'subkomponen', 'akun', 'anggaran', 'kodesatker', 'kodeunit', 'tahun'];

    public function scopeOrder($data)
    {
        return $data    ->orderby('program')    
                        ->orderby('kegiatan')   
                        ->orderby('kro')
                        ->orderby('ro')
                        ->orderby('komponen')
                        ->orderby('subkomponen')
                        ->orderby('akun');
    }

    public function unit()
    {
        return $this->belongsTo(unit::class, 'kodeunit', 'kodeunit');
    }

    public function scopePagusatker()
    {
        return $this->where('tahun', session()->get('tahun'))->where('kodesatker', session()->get('kdsatker'));
    }

    public function realisasi()
    {
        return $this->hasMany(realisasi::class);
    }

    public function sspb()
    {
        return $this->hasMany(sspb::class);
    }

    public function ppk()
    {
        return $this->belongsToMany(RefPPK::class, 'mapingpaguppks', 'pagu_id', 'user_id', 'id', 'nip');
    }

    public function tagihan()
    {
        return $this->hasManyThrough(tagihan::class, realisasi::class, 'pagu_id', 'id', 'id', 'tagihan_id');
    }
    public function scopePagustafppk($data)
    {
        if (Gate::allows('Staf_PPK')) {
            return $data->whereHas('unit', function ($val) {
                $val->stafppk();
            });
        }
    }

    public function mapingppk()
    {
        return $this->hasOne(mapingpaguppk::class);
    }

    public function scopePagunonppk($data)
    {
        return $data->doesntHave('ppk');
    }

    public function scopePaguppk($data, $nip)
    {
        return $data->wherehas('ppk', function ($val) use ($nip) {
            return $val->where('user_id', $nip);
        });
    }

    public function scopePaguUnit($data, $kodeunit)
    {
        return $data->where('kodeunit', $kodeunit);
    }

    public function scopeJenisbelanja($data, $jenis)
    {
        return $data->whereRaw('left(pagus.akun, 2) = ' . $jenis);
    }

    public function scopeSearchprogram($data)
    {
        if (request('program')) {
            return $data->where('program', 'like', '%' . request('program') . '%');
        }
    }

    public function scopeSearchkegiatan($data)
    {
        if (request('kegiatan')) {
            return $data->where('kegiatan', 'like', '%' . request('kegiatan') . '%');
        }
    }

    public function scopeSearchkro($data)
    {
        if (request('kro')) {
            return $data->where('kro', 'like', '%' . request('kro') . '%');
        }
    }

    public function scopeSearchro($data)
    {
        if (request('ro')) {
            return $data->where('ro', 'like', '%' . request('ro') . '%');
        }
    }

    public function scopeSearchkomponen($data)
    {
        if (request('komponen')) {
            return $data->where('komponen', 'like', '%' . request('komponen') . '%');
        }
    }

    public function scopeSearchsubkomponen($data)
    {
        if (request('subkomponen')) {
            return $data->where('subkomponen', 'like', '%' . request('subkomponen') . '%');
        }
    }

    public function scopeSearchakun($data)
    {
        if (request('akun')) {
            return $data->where('akun', 'like', '%' . request('akun') . '%');
        }
    }

    public function scopeRealisasiBulananPpk($data, $id, $bulan)
    {
        $pagu = $data
            ->whereHas('ppk', function ($val) use ($id) {
                $val->where('user_id', $id);
            })
            ->where('pagus.tahun', session()->get('tahun'));
        if (request('sp2d') === 'ya') {
            $realisasi = realisasi::whereIn('pagu_id', $pagu->pluck('id'))->whereHas('spm', function ($val) use ($bulan) {
                $val->whereRaw('LPAD(MONTH(spms.tanggal_sp2d), 2, 0) <= ' . $bulan);
            })
                ->groupBy('pagu_id')->selectRaw('sum(realisasi) as total_realisasi, pagu_id');
            $sspb = sspb::whereIn('pagu_id', $pagu->pluck('id'))
                ->whereRaw('LPAD(MONTH(sspbs.tanggal_sspb), 2, 0) <= ' . $bulan)->groupBy('pagu_id')->groupBy('pagu_id')
                ->selectRaw('sum(nominal_sspb) as total_sspb, pagu_id');
            return $pagu->leftJoinSub($realisasi, 'realisasis', function (JoinClause $join) {
                $join->on('realisasis.pagu_id', '=', 'pagus.id');
            })->leftJoinSub($sspb, 'sspbs', function (JoinClause $join) {
                $join->on('sspbs.pagu_id', '=', 'pagus.id');
            })
                ->selectRaw('CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, anggaran, total_realisasi, total_sspb')
            ;
        } else {
            $realisasi = realisasi::whereIn('pagu_id', $pagu->pluck('id'))
                ->whereHas('tagihan', function ($val) use ($bulan) {
                    $val->whereRaw('LPAD(MONTH(tagihans.tgltagihan), 2, 0) <= ' . $bulan);
                })
                ->groupBy('pagu_id')->selectRaw('sum(realisasi) as total_realisasi, pagu_id');
            $sspb = sspb::whereIn('pagu_id', $pagu->pluck('id'))
                ->whereHas('tagihan', function ($val) use ($bulan) {
                    $val->whereRaw('LPAD(MONTH(tagihans.tgltagihan), 2, 0) <= ' . $bulan);
                })
                ->selectRaw('sum(nominal_sspb) as total_sspb, pagu_id');
            return $pagu->leftJoinSub($realisasi, 'realisasis', function (JoinClause $join) {
                $join->on('realisasis.pagu_id', '=', 'pagus.id');
            })->leftJoinSub($sspb, 'sspbs', function (JoinClause $join) {
                $join->on('sspbs.pagu_id', '=', 'pagus.id');
            })
                ->selectRaw('CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, anggaran, total_realisasi, total_sspb')
            ;
        }
    }

    public function scopeRealisasiBulananUnit($data, $unit, $bulan)
    {
        $pagu = $data
            ->where('kodesatker', $unit->kodesatker)
            ->where('kodeunit', $unit->kodeunit)
            ->where('pagus.tahun', session()->get('tahun'));
        if (request('sp2d') === 'ya') {
            $realisasi = realisasi::whereIn('pagu_id', $pagu->pluck('id'))->whereHas('spm', function ($val) use ($bulan) {
                $val->whereRaw('LPAD(MONTH(spms.tanggal_sp2d), 2, 0) <= ' . $bulan);
            })
                ->groupBy('pagu_id')->selectRaw('sum(realisasi) as total_realisasi, pagu_id');
            $sspb = sspb::whereIn('pagu_id', $pagu->pluck('id'))
                ->whereRaw('LPAD(MONTH(sspbs.tanggal_sspb), 2, 0) <= ' . $bulan)->groupBy('pagu_id')->groupBy('pagu_id')
                ->selectRaw('sum(nominal_sspb) as total_sspb, pagu_id');
            return $pagu->leftJoinSub($realisasi, 'realisasis', function (JoinClause $join) {
                $join->on('realisasis.pagu_id', '=', 'pagus.id');
            })->leftJoinSub($sspb, 'sspbs', function (JoinClause $join) {
                $join->on('sspbs.pagu_id', '=', 'pagus.id');
            })
                ->selectRaw('CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, anggaran, total_realisasi, total_sspb')
            ;
        } else {
            $realisasi = realisasi::whereIn('pagu_id', $pagu->pluck('id'))
                ->whereHas('tagihan', function ($val) use ($bulan) {
                    $val->whereRaw('LPAD(MONTH(tagihans.tgltagihan), 2, 0) <= ' . $bulan);
                })
                ->groupBy('pagu_id')->selectRaw('sum(realisasi) as total_realisasi, pagu_id');
            $sspb = sspb::whereIn('pagu_id', $pagu->pluck('id'))
                ->whereHas('tagihan', function ($val) use ($bulan) {
                    $val->whereRaw('LPAD(MONTH(tagihans.tgltagihan), 2, 0) <= ' . $bulan);
                })
                ->selectRaw('sum(nominal_sspb) as total_sspb, pagu_id');
            return $pagu->leftJoinSub($realisasi, 'realisasis', function (JoinClause $join) {
                $join->on('realisasis.pagu_id', '=', 'pagus.id');
            })->leftJoinSub($sspb, 'sspbs', function (JoinClause $join) {
                $join->on('sspbs.pagu_id', '=', 'pagus.id');
            })
                ->selectRaw('CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, anggaran, total_realisasi, total_sspb')
            ;
        }
    }

    public function scopeRealisasiBulanan($data, $bulan)
    {
        $realisasi = realisasi::whereIn('pagu_id', $data->pluck('id'))->whereHas('spm', function ($val) use ($bulan) {
            $val->whereRaw('LPAD(MONTH(spms.tanggal_sp2d), 2, 0) = ' . $bulan);
        })
            ->groupBy('pagu_id')->selectRaw('sum(realisasi) as total_realisasi, pagu_id');
        $sspb = sspb::whereIn('pagu_id', $data->pluck('id'))
            ->whereRaw('LPAD(MONTH(sspbs.tanggal_sspb), 2, 0) = ' . $bulan)->groupBy('pagu_id')->groupBy('pagu_id')
            ->selectRaw('sum(nominal_sspb) as total_sspb, pagu_id');

        return $data->leftJoinSub($realisasi, 'realisasis', function (JoinClause $join) {
            $join->on('realisasis.pagu_id', '=', 'pagus.id');
        })->leftJoinSub($sspb, 'sspbs', function (JoinClause $join) {
            $join->on('sspbs.pagu_id', '=', 'pagus.id');
        })
            ->selectRaw('program, kegiatan, kro, ro, komponen, subkomponen, akun, CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, anggaran, total_realisasi, total_sspb')
            ->orderBy('pok')
            ->get();
    }

    public function scopeRealisasiBulananWithSum($data, $bulan)
    {
        $realisasi = realisasi::whereIn('pagu_id', $data->pluck('id'))->whereHas('spm', function ($val) use ($bulan) {
            $val->whereRaw('LPAD(MONTH(spms.tanggal_sp2d), 2, 0) <= ' . $bulan);
        })
            ->groupBy('pagu_id')->selectRaw('sum(realisasi) as total_realisasi, pagu_id');
        $sspb = sspb::whereIn('pagu_id', $data->pluck('id'))
            ->whereRaw('LPAD(MONTH(sspbs.tanggal_sspb), 2, 0) <= ' . $bulan)->groupBy('pagu_id')->groupBy('pagu_id')
            ->selectRaw('sum(nominal_sspb) as total_sspb, pagu_id');
        return $data->leftJoinSub($realisasi, 'realisasis', function (JoinClause $join) {
            $join->on('realisasis.pagu_id', '=', 'pagus.id');
        })->leftJoinSub($sspb, 'sspbs', function (JoinClause $join) {
            $join->on('sspbs.pagu_id', '=', 'pagus.id');
        })
            ->selectRaw('program, kegiatan, kro, ro, komponen, subkomponen, akun, CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, anggaran, total_realisasi, total_sspb')
            ->orderBy('pok')
            ->get();
    }

    public function scopeRekapSPM($data, $program = null, $kegiatan = null, $kro = null, $akun = null)
    {
        $data->with(['realisasi' => function ($query) {
            return $query->whereHas('tagihan', function ($q) {
                $q->whereHas('spm');
            })->with(['tagihan' => function ($q) {
                return $q->whereHas('spm')->select('id', 'jnstagihan', 'notagihan', 'spm_id')->with('spm');
            }])->select(['pagu_id', 'tagihan_id', 'realisasi']);
        }])->selectRaw('id, program, kegiatan, kro, ro, komponen, subkomponen, akun, CONCAT(program, ".", kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok')
            ->orderBy('pok')
        ;
        if ($program && $kegiatan && $kro) {
            $data->where('program', $program)->where('kegiatan', $kegiatan)->where('kro', $kro);
        }
        if ($akun) {
            $data->where('akun', $akun);
        }

        return $data;
    }
}
