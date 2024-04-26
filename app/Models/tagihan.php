<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class tagihan extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'notagihan',
        'jnstagihan',
        'kodeunit',
        'kodedokumen',
        'status',
        'tgltagihan',
        'kodesatker',
        'tahun',
        'uraian',
        'ppk_id',
        'staf_ppk',
        'tanggal_spm',
        'tanggal_sp2d',
        'nomor_sp2d',
        'catatan',
    ];

    public function ppk()
    {
        return $this->belongsTo(RefPPK::class, 'ppk_id', 'nip');
    }

    public function stafPpk()
    {
        return $this->belongsTo(RefStafPPK::class, 'staf_ppk', 'nip');
    }

    public function unit()
    {
        return $this->belongsTo(unit::class, 'kodeunit', 'kodeunit');
    }

    public function dokumen()
    {
        return $this->belongsTo(dokumen::class, 'kodedokumen', 'kodedokumen');
    }

    public function berkasupload()
    {
        return $this->hasMany(berkasupload::class);
    }

    public function realisasi()
    {
        return $this->hasMany(realisasi::class);
    }

    public function sspb()
    {
        return $this->hasMany(sspb::class);
    }

    public function dnp()
    {
        return $this->hasMany(dnp::class);
    }

    public function dnpPerjadin()
    {
        return $this->hasMany(DnpPerjadin::class);
    }

    public function dnpHonor()
    {
        return $this->hasMany(DnpHonorarium::class);
    }

    public function nominaldnp()
    {
        return $this->hasManyThrough(nominaldnp::class, dnp::class);
    }

    public function register()
    {
        return $this->hasOne(register_tagihan::class);
    }

    public function pph()
    {
        return $this->hasMany(pphrekanan::class);
    }

    public function ppn()
    {
        return $this->hasMany(ppnrekanan::class);
    }

    public function scopeNotregistered($data)
    {
        return $data->where('status', 1)->doesntHave('register');
    }

    public function scopeUnverified($data)
    {
        return $data->where('status', 2);
    }

    public function scopePpspm($data)
    {
        return $data->where('status', 3);
    }

    public function scopeBendahara($data)
    {
        return $data->where('status', 4);
    }

    public function scopeArsip($data)
    {
        return $data->where('status', 5);
    }

    public function spm()
    {
        return $this->hasOne(spm::class);
    }

    public function payroll()
    {
        return $this->hasMany(payroll::class);
    }

    public function scopeTagihanppk($data)
    {
            return $data->where('ppk_id', auth()->user()->nip);
    }

    public function scopeTagihanStafPPK($data)
    {
        return $data->whereIn('ppk_id', session()->get('ppk'))->whereIn('kodeunit', session()->get('unit'));
    }
    public function scopeTagihanverifikator($data)
    {
        return $data->where('jnstagihan', '!=', '2')->wherehas('unit', function ($val) {
            $val->wherehas('verifikator', function ($val) {
                $val->where('id', auth()->user()->id);
            });
        });
    }

    public function scopeTagihanverifikatorKKP($data)
    {
        return $data
        ->where('jnstagihan', 2)
        ;
    }

    public function scopeTagihansatker($data)
    {
        return $data->where('kodesatker', session()->get('kdsatker'))->where('tahun', session()->get('tahun'));
    }

    public function scopeTagihanBLBI($data)
    {
        return $data    ->where('kodesatker', session()->get('kdsatker'))
                        ->wherehas('dokumen', function ($val) {
                            $val->where('blbi', true);
                        })
                        ->where('tahun', session()->get('tahun'));
    }

    public function scopeTagihanNonBLBI($data)
    {
        return $data    ->where('kodesatker', session()->get('kdsatker'))
                        ->wherehas('dokumen', function ($val) {
                            $val->where('blbi', false);
                        })
                        ->where('tahun', session()->get('tahun'));
    }

    public function log()
    {
        return $this->hasMany(logtagihan::class);
    }

    public function rekanan()
    {
        return $this->belongsToMany(rekanan::class, 'rekanantagihan');
    }

    public function scopeSearch($data)
    {
        if (request('search')) {
            return $data->where('notagihan', 'like', '%' . request('search') . '%')->orwhere('uraian', 'like', '%' . request('search') . '%');
        }
    }

    public function scopeOrder($data)
    {
        return $data->orderby('tgltagihan', 'DESC')
            ->orderby('notagihan', 'DESC')
            ->orderby('created_at', 'DESC')
            ;
    }

    public function scopeRealisasiBulananPpk($data, $nip)
    {
        if (request('sp2d') === 'ya') {
            $data->where('ppk_id', $nip)
                ->where('tahun', session()->get('tahun'))
                ->leftJoin('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                ->leftJoin('bulans', function ($join) {
                    $join->on('bulans.kodebulan', '=', DB::raw('LPAD(MONTH(tanggal_sp2d), 2, "0")'));
                })
                ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                ->selectRaw('LPAD(MONTH(tanggal_sp2d), 2, "0") as bulan, sum(realisasi) as total_realisasi, namabulan, sum(nominal_sspb) as total_sspb')
                ->groupBy('bulan');
        } else {
            $data->where('ppk_id', $nip)
                ->where('tahun', session()->get('tahun'))
                ->leftJoin('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                ->leftjoin('bulans', function ($join) {
                    $join->on('bulans.kodebulan', '=', DB::raw('LPAD(MONTH(tagihans.tgltagihan), 2, "0")'));
                })
                ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                ->selectRaw('LPAD(MONTH(tgltagihan), 2, "0") as bulan, sum(realisasi) as total_realisasi, namabulan, sum(nominal_sspb) as total_sspb')
                ->groupBy('bulan');
        }
    }

    public function scopeRealisasiPaguBulananPpk($data, $nip)
    {
        if (request('sp2d') === 'ya') {
            $data->where('ppk_id', $nip)
                ->where('tahun', session()->get('tahun'))
                ->leftJoin('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                ->leftJoin('bulans', function ($join) {
                    $join->on('bulans.kodebulan', '=', DB::raw('LPAD(MONTH(tanggal_sp2d), 2, "0")'));
                })
                ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                ->selectRaw('LPAD(MONTH(tanggal_sp2d), 2, "0") as bulan, sum(realisasi) as total_realisasi, namabulan, sum(nominal_sspb) as total_sspb')
                ->groupBy('bulan');
        } else {
            $data->where('ppk_id', $nip)
                ->where('tahun', session()->get('tahun'))
                ->leftJoin('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                ->leftjoin('bulans', function ($join) {
                    $join->on('bulans.kodebulan', '=', DB::raw('LPAD(MONTH(tagihans.tgltagihan), 2, "0")'));
                })
                ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                ->selectRaw('LPAD(MONTH(tgltagihan), 2, "0") as bulan, sum(realisasi) as total_realisasi, namabulan, sum(nominal_sspb) as total_sspb')
                ->groupBy('bulan');
        }
    }

    public function scopeRealisasiTagihanPerBulanPpk($data, $nip, $bulan)
    {
        if (request('sp2d') === 'ya') {
            if ($bulan === "null") {
                return  $data->where('ppk_id', $nip)
                    ->where('tagihans.tahun', session()->get('tahun'))
                    ->where('tanggal_sp2d', null)
                    ->join('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                    ->join('pagus', 'realisasis.pagu_id', '=', 'pagus.id')
                    ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                    ->groupBy('tagihans.id', 'realisasis.id')
                    ->selectRaw('notagihan, jnstagihan, status, tgltagihan, uraian, CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, realisasi, tanggal_sp2d, realisasis.id, nominal_sspb, tgltagihan');
            } else {
                return  $data->where('ppk_id', $nip)
                    ->where('tagihans.tahun', session()->get('tahun'))
                    ->where(DB::raw('MONTH(tanggal_sp2d)'), $bulan)
                    ->join('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                    ->join('pagus', 'realisasis.pagu_id', '=', 'pagus.id')
                    ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                    ->groupBy('tagihans.id', 'realisasis.id')
                    ->selectRaw('notagihan, jnstagihan, status, tgltagihan, uraian, CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, realisasi, tanggal_sp2d, realisasis.id, nominal_sspb, tgltagihan');
            }
        } else {
            return  $data->where('ppk_id', $nip)
                ->where(DB::raw('MONTH(tgltagihan)'), $bulan)
                ->where('tagihans.tahun', session()->get('tahun'))
                ->join('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                ->join('pagus', 'realisasis.pagu_id', '=', 'pagus.id')
                ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                ->groupBy('tagihans.id', 'realisasis.id')
                ->selectRaw('notagihan, jnstagihan, status, tgltagihan, uraian, CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, realisasi, tanggal_sp2d, realisasis.id, nominal_sspb, tgltagihan');
        }
    }

    public function scopeRealisasiBulananUnit($data, $unit)
    {
        if (request('sp2d') === 'ya') {
            $data->where('kodesatker', $unit->kodesatker)
                ->where('kodeunit', $unit->kodeunit)
                ->where('tahun', session()->get('tahun'))
                ->leftJoin('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                ->leftJoin('bulans', function ($join) {
                    $join->on('bulans.kodebulan', '=', DB::raw('LPAD(MONTH(tanggal_sp2d), 2, "0")'));
                })
                ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                ->selectRaw('LPAD(MONTH(tanggal_sp2d), 2, "0") as bulan, sum(realisasi) as total_realisasi, namabulan, sum(nominal_sspb) as total_sspb')
                ->groupBy('bulan');
        } else {
            $data->where('kodesatker', $unit->kodesatker)
                ->where('kodeunit', $unit->kodeunit)
                ->where('tahun', session()->get('tahun'))
                ->leftJoin('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                ->leftjoin('bulans', function ($join) {
                    $join->on('bulans.kodebulan', '=', DB::raw('LPAD(MONTH(tagihans.tgltagihan), 2, "0")'));
                })
                ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                ->selectRaw('LPAD(MONTH(tgltagihan), 2, "0") as bulan, sum(realisasi) as total_realisasi, namabulan, sum(nominal_sspb) as total_sspb')
                ->groupBy('bulan');
        }
    }

    public function scopeRealisasiTagihanPerBulanUnit($data, $unit, $bulan)
    {
        if (request('sp2d') === 'ya') {
            if ($bulan === "null") {
                return  $data->where('tagihans.kodesatker', $unit->kodesatker)
                    ->where('tagihans.kodeunit', $unit->kodeunit)
                    ->where('tagihans.tahun', session()->get('tahun'))
                    ->where('tanggal_sp2d', null)
                    ->join('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                    ->join('pagus', 'realisasis.pagu_id', '=', 'pagus.id')
                    ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                    ->groupBy('tagihans.id', 'realisasis.id')
                    ->selectRaw('notagihan, jnstagihan, status, tgltagihan, uraian, CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, realisasi, tanggal_sp2d, realisasis.id, nominal_sspb, tgltagihan');
            } else {
                return  $data->where('tagihans.kodesatker', $unit->kodesatker)
                    ->where('tagihans.kodeunit', $unit->kodeunit)
                    ->where('tagihans.tahun', session()->get('tahun'))
                    ->where(DB::raw('MONTH(tanggal_sp2d)'), $bulan)
                    ->join('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                    ->join('pagus', 'realisasis.pagu_id', '=', 'pagus.id')
                    ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                    ->groupBy('tagihans.id', 'realisasis.id')
                    ->selectRaw('notagihan, jnstagihan, status, tgltagihan, uraian, CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, realisasi, tanggal_sp2d, realisasis.id, nominal_sspb, tgltagihan');
            }
        } else {
            return  $data->where('tagihans.kodesatker', $unit->kodesatker)
                ->where('tagihans.kodeunit', $unit->kodeunit)
                ->where('tagihans.tahun', session()->get('tahun'))
                ->where(DB::raw('MONTH(tgltagihan)'), $bulan)
                ->join('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                ->join('pagus', 'realisasis.pagu_id', '=', 'pagus.id')
                ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                ->groupBy('tagihans.id', 'realisasis.id')
                ->selectRaw('notagihan, jnstagihan, status, tgltagihan, uraian, CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, realisasi, tanggal_sp2d, realisasis.id, nominal_sspb, tgltagihan');
        }
    }

    public function scopeCleansingSPBy($data)
    {
        return $this->tagihanSatker()->where('tahun', session()->get('tahun'))
            ->where('status', '>=', 4)
            ->where('jnstagihan', 0)
            ->where(function (Builder $query) {
                $query->where('nomor_sp2d', null)->orWhere('nomor_sp2d', '')->orWhere('tanggal_sp2d', null)->orWhere('tanggal_sp2d', '0000-00-00');
            });
    }

    public function scopeCleansingSPP()
    {
        return $this->tagihanSatker()->where('tahun', session()->get('tahun'))
            ->where('status', '>=', 4)
            ->where('jnstagihan', 1)
            ->where(function (Builder $query) {
                $query->where('nomor_sp2d', null)->orWhere('nomor_sp2d', '')->orWhere('tanggal_sp2d', null)->orWhere('tanggal_sp2d', '0000-00-00');
            });
    }

    public function scopeCleansingKKP()
    {
        return $this->tagihanSatker()->where('tahun', session()->get('tahun'))
            ->where('status', '>=', 4)
            ->where('jnstagihan', 2)
            ->where(function (Builder $query) {
                $query->where('nomor_sp2d', null)->orWhere('nomor_sp2d', '')->orWhere('tanggal_sp2d', null)->orWhere('tanggal_sp2d', '0000-00-00');
            });
    }

    public function scopeCleansingTagihan($data)
    {
        return $data->tagihanSatker()->where('tahun', session()->get('tahun'))
            ->selectRaw('jnstagihan, notagihan, count(*) as jml')
            ->groupBy(['jnstagihan', 'notagihan'])
            ->havingRaw('count(*) > 1');
    }

    public function scopeCleansingDetailTagihan($data, $jns, $nomor)
    {
        return $data->tagihanSatker()->where('tahun', session()->get('tahun'))
            ->where('jnstagihan', $jns)
            ->where('notagihan', $nomor);
    }
}
