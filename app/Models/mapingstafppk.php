<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mapingstafppk extends Model
{
    use Uuids;
    use HasFactory;
    protected $fillable = [
        'staf_id',
        'ppk_id',
    ];

    public function ppk()
    {
        return $this->belongsTo(User::class, 'ppk_id');
    }
}
