<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pphrekanan extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'rekanan_id',
        'tagihan_id',
        'objekpajak_id',
        'pph',
        'ntpn',
        'tanggalntpn',
    ];

    public function objekpajak()
    {
        return $this->belongsTo(objekpajak::class, 'objekpajak_id', 'kode');
    }

    public function tagihan()
    {
        return $this->belongsTo(tagihan::class);
    }

    public function rekanan()
    {
        return $this->belongsTo(rekanan::class);
    }

    public function scopeMypph($data, $tagihan, $rekanan)
    {
       return $data->where('tagihan_id', $tagihan->id)->where('rekanan_id', $rekanan->id);
    }

    public function scopePphunit($data)
    {
        return $data->wherehas('tagihan', function($val){
            $val->where('kodesatker', auth()->user()->satker);
        });
    }

    public function scopeTahunpajak($data)
    {
        $data->whereYear('tanggalntpn',session()->get('tahun'))->orwherehas('tagihan', function($val){
            $val->where('jnstagihan', '1')->wherehas('spm', function($val2){
                $val2->whereYear('tanggal_sp2d', session()->get('tahun'));
            });
        });
    }

    public function scopeMasapajak($data)
    {
        if (request('bulan')) {
            $data->whereMonth('tanggalntpn',request('bulan'))->orwherehas('tagihan', function($val){
                $val->where('jnstagihan', '1')->wherehas('spm', function($val2){
                    $val2->whereMonth('tanggal_sp2d', request('bulan'));
                });
            });
        }
    }
}
