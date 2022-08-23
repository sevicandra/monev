<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class berkasupload extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'tagihan_id',
        'berkas_id',
        'uraian',
        'file',
    ];

    public function tagihan(){
        return $this->belongsTo(tagihan::class);
    }

    public function berkas()
    {
        return $this->belongsTo(berkas::class);
    }

    public function scopeCekberkas1($data)
    {
        $data->wherehas('berkas', function($val){
            $val->where('kodeberkas', '01');
        });
    }

    public function scopeCekberkas2($data)
    {
        $data->wherehas('berkas', function($val){
            $val->where('kodeberkas', '02');
        });
    }

    public function scopeCekberkas3($data)
    {
        $data->wherehas('berkas', function($val){
            $val->where('kodeberkas', '03');
        });
    }

    public function scopeCekberkas5($data)
    {
        $data->wherehas('berkas', function($val){
            $val->where('kodeberkas', '05');
        });
    }
}
