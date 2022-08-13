<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class unit extends Model
{
    use Uuids;
    use HasFactory;
    
    protected $fillable = [
        'kodeunit',
        'kodesatker',
        'namaunit',
    ];


    public function satker()
    {
        return $this->belongsTo(satker::class, 'kodesatker', 'kodesatker');
    }

    public function scopeMyunit()
    {
        return $this->where('kodesatker', auth()->user()->satker)->orderby('kodeunit')->get();
    }
}
