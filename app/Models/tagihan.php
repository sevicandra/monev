<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
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
        'ppk_id'
    ];

    public function ppk()
    {
        return $this->belongsTo(User::class, 'ppk_id', 'nip');
    }

    public function unit()
    {
        return $this->belongsTo(unit::class, 'kodeunit', 'kodeunit');
    }

    public function dokumen()
    {
        return $this->belongsTo(dokumen::class, 'kodedokumen', 'kodedokumen');
    }

    public function berkasupload(){
        return $this->hasMany(berkasupload::class);
    }

    public function realisasi()
    {
        return $this->hasMany(realisasi::class);
    }
    
    public function dnp()
    {
        return $this->hasMany(dnp::class);
    }

    public function nominaldnp()
    {
        return $this->hasManyThrough(nominaldnp::class, dnp::class);
    }

    public function register()
    {
        return $this->hasOne(register_tagihan::class);
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

    public function scopeTagihanppk($data)
    {
        if (Gate::allows('PPK', auth()->user()->id)) {
            return $data->where('ppk_id', auth()->user()->nip);
        }

        if (Gate::allows('Staf_PPK', auth()->user()->id)) {
            return $data->where('ppk_id', auth()->user()->mapingstafppk->ppk_id);
        }
    }

    public function scopeTagihanverifikator($data)
    {
        return $data->wherehas('unit', function($val){
            $val->wherehas('verifikator', function($val){
                $val->where('id', auth()->user()->id);
            });
        });
    }

    public function scopeTagihansatker($data)
    {
        return $data->where('kodesatker', auth()->user()->satker)->where('tahun', session()->get('tahun'));
    }

    public function log()
    {
        return $this->hasMany(logtagihan::class);
    }

    public function rekanan()
    {
        return $this->belongsToMany(rekanan::class,'rekanantagihan');
    }

    public function scopeSearch($data)
    {
        if (request('search')) {
            return $data->where('notagihan', 'like', '%'.request('search').'%');
        }
    }

    public function scopeOrder($data)
    {
        return $data    ->orderby('tgltagihan', 'DESC')
                        ->orderby('notagihan', 'DESC');
    }

    public function scopeRealisasiBulananPpk($data, $nip)
    {
        if (request('sp2d') === 'ya') {
            $data   ->where('ppk_id', $nip)
                    ->where('tahun', session()->get('tahun'))
                    ->leftJoin('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                    ->leftJoin('spms', 'spms.tagihan_id', '=', 'tagihans.id')
                    ->leftJoin('bulans', function ($join) {
                        $join->on('bulans.kodebulan', '=', DB::raw('LPAD(MONTH(spms.tanggal_sp2d), 2, "0")'));
                    })
                    ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                    ->selectRaw('LPAD(MONTH(tanggal_sp2d), 2, "0") as bulan, sum(realisasi) as total_realisasi, namabulan, sum(nominal_sspb) as total_sspb')
                    ->groupBy('bulan')
                    ;
        }else{
            $data   ->where('ppk_id', $nip)
                    ->where('tahun', session()->get('tahun'))
                    ->leftJoin('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                    ->leftjoin('bulans', function ($join) {
                        $join->on('bulans.kodebulan', '=', DB::raw('LPAD(MONTH(tagihans.tgltagihan), 2, "0")'));
                    })
                    ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                    ->selectRaw('LPAD(MONTH(tgltagihan), 2, "0") as bulan, sum(realisasi) as total_realisasi, namabulan, sum(nominal_sspb) as total_sspb')
                    ->groupBy('bulan')
                    ;
        }
    }

    public function scopeRealisasiPaguBulananPpk($data, $nip)
    {
        if (request('sp2d') === 'ya') {
            $data   ->where('ppk_id', $nip)
                    ->where('tahun', session()->get('tahun'))
                    ->leftJoin('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                    ->leftJoin('spms', 'spms.tagihan_id', '=', 'tagihans.id')
                    ->leftJoin('bulans', function ($join) {
                        $join->on('bulans.kodebulan', '=', DB::raw('LPAD(MONTH(spms.tanggal_sp2d), 2, "0")'));
                    })
                    ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                    ->selectRaw('LPAD(MONTH(tanggal_sp2d), 2, "0") as bulan, sum(realisasi) as total_realisasi, namabulan, sum(nominal_sspb) as total_sspb')
                    ->groupBy('bulan')
                    ;
        }else{
            $data   ->where('ppk_id', $nip)
                    ->where('tahun', session()->get('tahun'))
                    ->leftJoin('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                    ->leftjoin('bulans', function ($join) {
                        $join->on('bulans.kodebulan', '=', DB::raw('LPAD(MONTH(tagihans.tgltagihan), 2, "0")'));
                    })
                    ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                    ->selectRaw('LPAD(MONTH(tgltagihan), 2, "0") as bulan, sum(realisasi) as total_realisasi, namabulan, sum(nominal_sspb) as total_sspb')
                    ->groupBy('bulan')
                    
                    ;
        }
    }

    public function scopeRealisasiTagihanPerBulanPpk($data, $nip, $bulan)
    {
        if (request('sp2d') === 'ya') {
            if ($bulan === "null") {
                return  $data   ->where('ppk_id', $nip)
                                ->leftjoin('spms', function($val)use($bulan){
                                    $val    ->on('spms.tagihan_id', '=', 'tagihans.id');
                                })
                                ->where('spms.tanggal_sp2d', null)
                                ->join('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                                ->join('pagus', 'realisasis.pagu_id', '=', 'pagus.id')
                                ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                                ->groupBy('tagihans.id', 'realisasis.id')
                                ->selectRaw('notagihan, jnstagihan, status, tgltagihan, uraian, CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, realisasi, tanggal_sp2d, realisasis.id, nominal_sspb, tgltagihan')
                ;
            }else{
                return  $data   ->where('ppk_id', $nip)
                                ->join('spms', function($val)use($bulan){
                                    $val    ->on('spms.tagihan_id', '=', 'tagihans.id')
                                            ->where(DB::raw('MONTH(tanggal_sp2d)'), $bulan);
                                })->join('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                                ->join('pagus', 'realisasis.pagu_id', '=', 'pagus.id')
                                ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                                ->groupBy('tagihans.id', 'realisasis.id')
                                ->selectRaw('notagihan, jnstagihan, status, tgltagihan, uraian, CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, realisasi, tanggal_sp2d, realisasis.id, nominal_sspb, tgltagihan')
                ;
            }
        }else{
            return  $data   ->where('ppk_id', $nip)
                            ->where(DB::raw('MONTH(tgltagihan)'), $bulan)
                            ->join('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                            ->join('pagus', 'realisasis.pagu_id', '=', 'pagus.id')
                            ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                            ->leftJoin('spms', 'spms.tagihan_id', '=', 'tagihans.id')
                            ->groupBy('tagihans.id', 'realisasis.id')
                            ->selectRaw('notagihan, jnstagihan, status, tgltagihan, uraian, CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, realisasi, tanggal_sp2d, realisasis.id, nominal_sspb, tgltagihan')
            ;
        }
    }

    public function scopeRealisasiBulananUnit($data, $unit)
    {
        if (request('sp2d') === 'ya') {
            $data   ->where('kodesatker', $unit->kodesatker)
                    ->where('kodeunit', $unit->kodeunit)
                    ->where('tahun', session()->get('tahun'))
                    ->leftJoin('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                    ->leftJoin('spms', 'spms.tagihan_id', '=', 'tagihans.id')
                    ->leftJoin('bulans', function ($join) {
                        $join->on('bulans.kodebulan', '=', DB::raw('LPAD(MONTH(spms.tanggal_sp2d), 2, "0")'));
                    })
                    ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                    ->selectRaw('LPAD(MONTH(tanggal_sp2d), 2, "0") as bulan, sum(realisasi) as total_realisasi, namabulan, sum(nominal_sspb) as total_sspb')
                    ->groupBy('bulan')
                    ;
        }else{
            $data   ->where('kodesatker', $unit->kodesatker)
                    ->where('kodeunit', $unit->kodeunit)
                    ->where('tahun', session()->get('tahun'))
                    ->leftJoin('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                    ->leftjoin('bulans', function ($join) {
                        $join->on('bulans.kodebulan', '=', DB::raw('LPAD(MONTH(tagihans.tgltagihan), 2, "0")'));
                    })
                    ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                    ->selectRaw('LPAD(MONTH(tgltagihan), 2, "0") as bulan, sum(realisasi) as total_realisasi, namabulan, sum(nominal_sspb) as total_sspb')
                    ->groupBy('bulan')
                    
                    ;
        }
    }

    public function scopeRealisasiTagihanPerBulanUnit($data, $unit, $bulan)
    {
        if (request('sp2d') === 'ya') {
            if ($bulan === "null") {
                return  $data   ->where('tagihans.kodesatker', $unit->kodesatker)
                                ->where('tagihans.kodeunit', $unit->kodeunit)
                                ->leftjoin('spms', function($val)use($bulan){
                                    $val    ->on('spms.tagihan_id', '=', 'tagihans.id');
                                    
                                })
                                ->where('spms.tanggal_sp2d', null)
                                ->join('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                                ->join('pagus', 'realisasis.pagu_id', '=', 'pagus.id')
                                ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                                ->groupBy('tagihans.id', 'realisasis.id')
                                ->selectRaw('notagihan, jnstagihan, status, tgltagihan, uraian, CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, realisasi, tanggal_sp2d, realisasis.id, nominal_sspb, tgltagihan')
                ;
            }else{
                return  $data   ->where('tagihans.kodesatker', $unit->kodesatker)
                                ->where('tagihans.kodeunit', $unit->kodeunit)
                                ->join('spms', function($val)use($bulan){
                                    $val    ->on('spms.tagihan_id', '=', 'tagihans.id')
                                            ->where(DB::raw('MONTH(tanggal_sp2d)'), $bulan);
                                })->join('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                                ->join('pagus', 'realisasis.pagu_id', '=', 'pagus.id')
                                ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                                ->groupBy('tagihans.id', 'realisasis.id')
                                ->selectRaw('notagihan, jnstagihan, status, tgltagihan, uraian, CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, realisasi, tanggal_sp2d, realisasis.id, nominal_sspb, tgltagihan')
                ;
            }
        }else{
            return  $data   ->where('tagihans.kodesatker', $unit->kodesatker)
                            ->where('tagihans.kodeunit', $unit->kodeunit)
                            ->where(DB::raw('MONTH(tgltagihan)'), $bulan)
                            ->join('realisasis', 'realisasis.tagihan_id', '=', 'tagihans.id')
                            ->join('pagus', 'realisasis.pagu_id', '=', 'pagus.id')
                            ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                            ->leftJoin('spms', 'spms.tagihan_id', '=', 'tagihans.id')
                            ->groupBy('tagihans.id', 'realisasis.id')
                            ->selectRaw('notagihan, jnstagihan, status, tgltagihan, uraian, CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, realisasi, tanggal_sp2d, realisasis.id, nominal_sspb, tgltagihan')
            ;
        }
    }
}