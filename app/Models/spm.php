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
        'tagihan_id',
        'tanggal_spm',
        'nomor_sp2d',
        'tanggal_sp2d',
    ];

    public function tagihan()
    {
        return $this->belongsTo(tagihan::class);
    }

    public function scopeDuplicate()
    {
        $duplicate =  $this->select('tagihan_id')->groupBy('tagihan_id')->havingRaw('count(*) > 1');
        return $this->whereIn('spms.tagihan_id', $duplicate)
        ->join('tagihans', function(JoinClause $join){
            $join->on('tagihans.id','=','spms.tagihan_id')->where('tagihans.tahun',  session()->get('tahun'))->where('kodesatker', auth()->user()->satker);
        })->orderBy('tagihans.notagihan')
        ->orderBy('tagihans.jnstagihan')
        ->select(['spms.id', 'spms.tanggal_sp2d', 'tagihans.notagihan', 'spms.nomor_sp2d', 'tagihans.tgltagihan', 'tagihans.jnstagihan'])
        ;
    }
}
