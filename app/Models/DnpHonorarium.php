<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DnpHonorarium extends Model
{
    use HasFactory, Uuids;

    public $table = "dnp_honorariums";

    protected $fillable = [
        'nama',
        'nip',
        'dasar',
        'jabatan',
        'gol',
        'npwp',
        'frekuensi',
        'nilai',
        'bruto',
        'pajak',
        'netto',
        'norek',
        'namarek',
        'bank',
        'tagihans_id'
    ];
}
