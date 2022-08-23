<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class register extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'tahun',
        'kodesatker',
        'ppk',
        'nomor',
        'ekstensi',
        'status',
        'file',
        'dokumen_id',
        'dokumen_date'
    ];

    public function register_tagihan()
    {
        return $this->hasMany(register_tagihan::class);
    }

    public function tagihan()
    {
        return $this->BelongsToMany(tagihan::class, register_tagihan::class);
    }
}
