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
        return $this->hasOne(sspb::class);
    }

    public function scopeRealisaijenisbelanja($data, $jenis)
    {
        $a=$jenis;
        return $data->wherehas('pagu', function($val)use($a){
            $val->where('tahun', session()->get('tahun'))->where('kodesatker', auth()->user()->satker)->whereRaw(DB::raw('left(akun, 2) = "'.$a.'"'));
        });
    }

    public function scopeSp2d($data)
    {
        if (request('sp2d')) {
            return $data->wherehas('tagihan', function($val){
                $val->wherehas('spm', function($val2){
                    $val2->where('nomor_sp2d', '!=' ,null);
                });
            });
        }
    }
}
