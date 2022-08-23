<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class register_tagihan extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'register_id',
        'tagihan_id',
    ];

    public function register()
    {
        return $this->belongsTo(register::class);
    }

    public function tagihan()
    {
        return $this->belongsTo(tagihan::class);
    }

}
