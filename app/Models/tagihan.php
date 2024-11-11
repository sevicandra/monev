<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
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
        'no_spm',
        'spm_id'
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
        return $this->belongsTo(spm::class);
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
            ->where('jnstagihan', 2);
    }

    public function scopeTagihansatker($data)
    {
        return $data->where('kodesatker', session()->get('kdsatker'))->where('tahun', session()->get('tahun'));
    }

    public function scopeTagihanBLBI($data)
    {
        return $data->where('kodesatker', session()->get('kdsatker'))
            ->wherehas('dokumen', function ($val) {
                $val->where('blbi', true);
            })
            ->where('tahun', session()->get('tahun'));
    }

    public function scopeTagihanNonBLBI($data)
    {
        return $data->where('kodesatker', session()->get('kdsatker'))
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
        switch (request('sb')) {
            case 'nomor_tagihan':
                $sb = 'notagihan';
                break;
            case 'tanggal_tagihan':
                $sb = 'tgltagihan';
                break;
            case 'updated':
                $sb = 'updated_at';
                break;
            default:
                $sb = 'notagihan';
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

        return $data->orderby($sb, $sd);
    }

    public function scopeFilter($data)
    {
        switch (request('jns')) {
            case 'SPBY':
                return $data->where('jnstagihan', 0);
            case 'SPP':
                return $data->where('jnstagihan', 1);
            case 'KKP':
                return $data->where('jnstagihan', 2);
            default:
                return $data;
        }
    }

    public function scopeRealisasiBulananPpk($data, $nip)
    {
        if (request('sp2d') === 'ya') {
            $data->where('ppk_id', $nip)
                ->where('tagihans.tahun', session()->get('tahun'))
                ->leftJoin('spms', 'spms.id', '=', 'tagihans.spm_id')
                ->leftJoin('bulans', function ($join) {
                    $join->on('bulans.kodebulan', '=', DB::raw('LPAD(MONTH(spms.tanggal_sp2d), 2, "0")'));
                })
                ->selectRaw('LPAD(MONTH(spms.tanggal_sp2d), 2, "0") as bulan, namabulan, tagihans.id')
                ->with('realisasi', 'sspb')
            ;
        } else {
            $data->where('ppk_id', $nip)
                ->where('tahun', session()->get('tahun'))
                ->leftjoin('bulans', function ($join) {
                    $join->on('bulans.kodebulan', '=', DB::raw('LPAD(MONTH(tagihans.tgltagihan), 2, "0")'));
                })
                ->selectRaw('LPAD(MONTH(tgltagihan), 2, "0") as bulan, namabulan, tagihans.id')
                ->with('realisasi', 'sspb');
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
                    ->doesntHave('spm')
                    ->join('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                    ->join('pagus', 'realisasis.pagu_id', '=', 'pagus.id')
                    ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                    ->groupBy('tagihans.id', 'realisasis.id')
                    ->selectRaw('notagihan, jnstagihan, status, tgltagihan, uraian, CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, realisasi, realisasis.id, sum(nominal_sspb) as nominal_sspb, tgltagihan');
            } else {
                return  $data->where('ppk_id', $nip)
                    ->where('tagihans.tahun', session()->get('tahun'))
                    ->leftJoin('spms', 'tagihans.spm_id', '=', 'spms.id')
                    ->where(DB::raw('MONTH(spms.tanggal_sp2d)'), $bulan)
                    ->join('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                    ->join('pagus', 'realisasis.pagu_id', '=', 'pagus.id')
                    ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                    ->groupBy('tagihans.id', 'realisasis.id')
                    ->selectRaw('notagihan, jnstagihan, status, tgltagihan, uraian, CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, realisasi, spms.tanggal_sp2d, realisasis.id, sum(nominal_sspb) as nominal_sspb, tgltagihan');
            }
        } else {
            return  $data->where('ppk_id', $nip)
                ->where(DB::raw('MONTH(tgltagihan)'), $bulan)
                ->where('tagihans.tahun', session()->get('tahun'))
                ->where(DB::raw('MONTH(tgltagihan)'), $bulan)
                ->leftJoin('spms', 'tagihans.spm_id', '=', 'spms.id')
                ->join('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                ->join('pagus', 'realisasis.pagu_id', '=', 'pagus.id')
                ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                ->groupBy('tagihans.id', 'realisasis.id')
                ->selectRaw('notagihan, jnstagihan, status, tgltagihan, uraian, CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, realisasi, spms.tanggal_sp2d, realisasis.id, sum(nominal_sspb) as nominal_sspb, tgltagihan');
        }
    }

    public function scopeRealisasiBulananUnit($data, $unit)
    {
        if (request('sp2d') === 'ya') {
            $data->where('kodesatker', $unit->kodesatker)
                ->where('kodeunit', $unit->kodeunit)
                ->where('tagihans.tahun', session()->get('tahun'))
                ->leftJoin('spms', 'spms.id', '=', 'tagihans.spm_id')
                ->leftJoin('bulans', function ($join) {
                    $join->on('bulans.kodebulan', '=', DB::raw('LPAD(MONTH(spms.tanggal_sp2d), 2, "0")'));
                })
                ->selectRaw('LPAD(MONTH(spms.tanggal_sp2d), 2, "0") as bulan, namabulan, tagihans.id')
                ->with('realisasi', 'sspb')
            ;
        } else {
            $data->where('kodesatker', $unit->kodesatker)
                ->where('kodeunit', $unit->kodeunit)
                ->where('tagihans.tahun', session()->get('tahun'))
                ->leftjoin('bulans', function ($join) {
                    $join->on('bulans.kodebulan', '=', DB::raw('LPAD(MONTH(tagihans.tgltagihan), 2, "0")'));
                })
                ->selectRaw('LPAD(MONTH(tgltagihan), 2, "0") as bulan, namabulan, tagihans.id')
                ->with('realisasi', 'sspb');
        }
        return $data;
    }

    public function scopeRealisasiTagihanPerBulanUnit($data, $unit, $bulan)
    {
        if (request('sp2d') === 'ya') {
            if ($bulan === "null") {
                return  $data->where('tagihans.kodesatker', $unit->kodesatker)
                    ->where('tagihans.kodeunit', $unit->kodeunit)
                    ->where('tagihans.tahun', session()->get('tahun'))
                    ->doesntHave('spm')
                    ->join('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                    ->join('pagus', 'realisasis.pagu_id', '=', 'pagus.id')
                    ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                    ->groupBy('tagihans.id', 'realisasis.id')
                    ->selectRaw('notagihan, jnstagihan, status, tgltagihan, uraian, CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, realisasi, realisasis.id, sum(nominal_sspb) as nominal_sspb, tgltagihan');
            } else {
                return  $data->where('tagihans.kodesatker', $unit->kodesatker)
                    ->where('tagihans.kodeunit', $unit->kodeunit)
                    ->where('tagihans.tahun', session()->get('tahun'))
                    ->leftJoin('spms', 'tagihans.spm_id', '=', 'spms.id')
                    ->where(DB::raw('MONTH(spms.tanggal_sp2d)'), $bulan)
                    ->join('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                    ->join('pagus', 'realisasis.pagu_id', '=', 'pagus.id')
                    ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                    ->groupBy('tagihans.id', 'realisasis.id')
                    ->selectRaw('notagihan, jnstagihan, status, tgltagihan, uraian, CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, realisasi, spms.tanggal_sp2d, realisasis.id, sum(nominal_sspb) as nominal_sspb, tgltagihan');
            }
        } else {
            return  $data->where('tagihans.kodesatker', $unit->kodesatker)
                ->where('tagihans.kodeunit', $unit->kodeunit)
                ->where('tagihans.tahun', session()->get('tahun'))
                ->leftJoin('spms', 'tagihans.spm_id', '=', 'spms.id')
                ->where(DB::raw('MONTH(tgltagihan)'), $bulan)
                ->join('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                ->join('pagus', 'realisasis.pagu_id', '=', 'pagus.id')
                ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                ->groupBy('tagihans.id', 'realisasis.id')
                ->selectRaw('notagihan, jnstagihan, status, tgltagihan, uraian, CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, realisasi, spms.tanggal_sp2d, realisasis.id, sum(nominal_sspb) as nominal_sspb, tgltagihan');
        }
    }

    public function scopeCleansingSPBy($data)
    {
        return $data->tagihanSatker()->where('tahun', session()->get('tahun'))
            ->where('status', '>=', 3)
            ->where('jnstagihan', 0)
            ->whereDoesntHave('spm');
    }

    public function scopeCleansingSPP($data)
    {
        return $data->tagihanSatker()->where('tahun', session()->get('tahun'))
            ->where('status', '>=', 3)
            ->where('jnstagihan', 1)
            ->whereDoesntHave('spm');
    }

    public function scopeCleansingKKP($data)
    {
        return $data->tagihanSatker()->where('tahun', session()->get('tahun'))
            ->where('status', '>=', 3)
            ->where('jnstagihan', 2)
            ->whereDoesntHave('spm');
    }

    public function scopeCleansingDuplikat($data)
    {
        return $data->tagihanSatker()->where('tahun', session()->get('tahun'))
            ->selectRaw('jnstagihan, notagihan, count(*) as jml')
            ->groupBy(['jnstagihan', 'notagihan'])
            ->havingRaw('count(*) > 1');
    }

    public function scopeCleansingDetailDuplikat($data, $jns, $nomor)
    {
        return $data->tagihanSatker()->where('tahun', session()->get('tahun'))
            ->where('jnstagihan', $jns)
            ->where('notagihan', $nomor);
    }

    public function scopeCleansingRekapSPM($data)
    {
        $data->tagihanSatker()
            ->whereNotNull('no_spm')
            ->rightJoin('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
            // ->selectRaw('realisasis.realisasi, no_spm as nomor_spm, nomor_sp2d, tanggal_sp2d, tanggal_spm')

        ;
    }
}
