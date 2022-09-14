<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nomor extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'tahun',
        'kodesatker',
        'ekstensi',
        'nomor',
        'tahun',
    ];
    
    public function satker()
    {
        return $this->belongsTo(satker::class, 'kodesatker', 'kodesatker');
    }

    public function scopeSearch($data)
    {
        if (request('search')) {
            return $data->where('kodesatker', 'like', '%'.request('search').'%');
        }
    }
}
