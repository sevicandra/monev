<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ppnrekanan extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'rekanan_id',
        'tagihan_id',
        'nomorfaktur',
        'tanggalfaktur',
        'ppn',
        'tarif',
        'ntpn',
        'tanggalntpn',
    ];

    public function tagihan()
    {
        return $this->belongsTo(tagihan::class);
    }

    public function rekanan()
    {
        return $this->belongsTo(rekanan::class);
    }

    public function scopeMyppn($data, $tagihan, $rekanan)
    {
        $data->where('tagihan_id', $tagihan->id)->where('rekanan_id', $rekanan->id);
    }

    public function scopePpnunit($data)
    {
        return $data->wherehas('tagihan', function($val){
            $val->where('kodesatker', session()->get('kdsatker'));
        });
    }

    public function scopeTahunpajak($data)
    {
        $data->whereYear('tanggalfaktur',session()->get('tahun'));
    }

    public function scopeMasapajak($data)
    {
        if (request('bulan')) {
            $data->whereMonth('tanggalfaktur',request('bulan'));
        }
    }
}
