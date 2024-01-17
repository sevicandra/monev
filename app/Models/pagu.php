<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Query\JoinClause;

class pagu extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'program',
        'kegiatan',
        'kro',
        'ro',
        'komponen',
        'subkomponen',
        'akun',
        'anggaran',
        'kodesatker',
        'kodeunit',
        'tahun',
    ];

    public function scopeOrder($data){
        return $data->orderby('program')->orderby('kegiatan')->orderby('kro')->orderby('ro')->orderby('komponen')->orderby('subkomponen')->orderby('akun');
    }

    public function unit()
    {
        return $this->belongsTo(unit::class, 'kodeunit', 'kodeunit');
    }

    public function scopePagusatker()
    {
        return $this->where('tahun', session()->get('tahun'))->where('kodesatker', auth()->user()->satker);
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

    public function scopePagustafppk($data )
    {
        if (Gate::allows('Staf_PPK', auth()->user()->id)) {
            return $data->whereHas('unit', function($val){
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

    public function scopePaguppk($data)
    {
        return $data->wherehas('ppk', function($val){
            if (Gate::allows('PPK', auth()->user()->id)) {
                return $val->where('user_id', auth()->user()->nip);
            }
    
            if (Gate::allows('Staf_PPK', auth()->user()->id)) {
                return $val->where('user_id', auth()->user()->mapingstafppk->ppk_id);
            }
        });
    }

    public function scopeJenisbelanja($data, $jenis)
    {
        return $data    ->whereRaw('left(pagus.akun, 2) = '. $jenis);
    }
    
    public function scopeSearchprogram($data)
    {
        if (request('program')) {
            return $data->where('program', 'like', '%'.request('program').'%');
        }
    }

    public function scopeSearchkegiatan($data)
    {
        if (request('kegiatan')) {
            return $data->where('kegiatan', 'like', '%'.request('kegiatan').'%');
        }
    }

    public function scopeSearchkro($data)
    {
        if (request('kro')) {
            return $data->where('kro', 'like', '%'.request('kro').'%');
        }
    }

    public function scopeSearchro($data)
    {
        if (request('ro')) {
            return $data->where('ro', 'like', '%'.request('ro').'%');
        }
    }

    public function scopeSearchkomponen($data)
    {
        if (request('komponen')) {
            return $data->where('komponen', 'like', '%'.request('komponen').'%');
        }
    }

    public function scopeSearchsubkomponen($data)
    {
        if (request('subkomponen')) {
            return $data->where('subkomponen', 'like', '%'.request('subkomponen').'%');
        }
    }

    public function scopeSearchakun($data)
    {
        if (request('akun')) {
            return $data->where('akun', 'like', '%'.request('akun').'%');
        }
    }

    public function scopeRealisasiBulananPpk($data, $id, $bulan)
    {
        if (request('sp2d') === 'ya') {

            return $data   ->whereHas('ppk', function($val)use($id){
                            $val->where('user_id', $id);
                    })
                    ->where('pagus.tahun', session()->get('tahun'))
                    ->leftJoin('view_realisasipagubulanan', function(JoinClause $join)use($bulan){
                        $join->on('pagus.id', '=', 'view_realisasipagubulanan.pagu_id')
                        ->where('view_realisasipagubulanan.bulan_sp2d', '<=', $bulan);
                    })
                    ->selectRaw('CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, anggaran, sum(realisasi) as realisasi, sum(pengembalian) as total_sspb')
                    ->groupBy('pagus.id')
                    ;
        }else{
            $realisasi    = DB::table('realisasis')
                            ->leftJoin('tagihans', 'tagihans.id', '=', 'realisasis.tagihan_id')
                            ->where(DB::raw('LPAD(MONTH(tagihans.tgltagihan), 2, "0")'),'<=', $bulan)
                            ->select('realisasis.*')
            ;
            return $data   ->whereHas('ppk', function($val)use($id){
                        $val->where('user_id', $id);
                    })
                    ->where('pagus.tahun', session()->get('tahun'))
                    ->leftJoinSub($realisasi, 'realisasis', function(JoinClause $join){
                        $join->on('realisasis.pagu_id', '=', 'pagus.id');
                    })
                    ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                    ->selectRaw('CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, anggaran, sum(realisasi) as realisasi, sum(nominal_sspb) as total_sspb')
                    ->groupBy('pagus.id')
                    
                    ;
        }
    }

    public function scopeRealisasiBulananUnit($data, $unit, $bulan)
    {
        if (request('sp2d') === 'ya') {
            return $data   ->where('kodesatker', $unit->kodesatker)
                    ->where('kodeunit', $unit->kodeunit)
                    ->where('pagus.tahun', session()->get('tahun'))
                    ->leftJoin('view_realisasipagubulanan', function(JoinClause $join)use($bulan){
                        $join->on('pagus.id', '=', 'view_realisasipagubulanan.pagu_id')
                        ->where('view_realisasipagubulanan.bulan_sp2d', '<=', $bulan);
                    })
                    ->selectRaw('CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, anggaran, sum(realisasi) as realisasi, sum(pengembalian) as total_sspb')
                    ->groupBy('pagus.id')
                    ;
        }else{
            $realisasi    = DB::table('realisasis')
                            ->leftJoin('tagihans', 'tagihans.id', '=', 'realisasis.tagihan_id')
                            ->where(DB::raw('LPAD(MONTH(tagihans.tgltagihan), 2, "0")'),'<=', $bulan)
                            ->select('realisasis.*')
            ;
            return $data   ->where('kodesatker', $unit->kodesatker)
                    ->where('kodeunit', $unit->kodeunit)
                    ->where('pagus.tahun', session()->get('tahun'))
                    ->leftJoinSub($realisasi, 'realisasis', function(JoinClause $join){
                        $join->on('realisasis.pagu_id', '=', 'pagus.id');
                    })
                    ->leftJoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')
                    ->selectRaw('CONCAT(program, "." ,kegiatan, ".", kro, ".", ro, ".", komponen, ".", subkomponen, ".", akun) AS pok, anggaran, sum(realisasi) as realisasi, sum(nominal_sspb) as total_sspb')
                    ->groupBy('pagus.id')
                    
                    ;
        }
    }
}
