<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mapingpaguppk extends Model
{
    use Uuids;
    use HasFactory;
    
    protected $fillable = [
        'pagu_id',
        'user_id',
    ];
    public function pagu()
    {
        return $this->belongsTo(pagu::class);
    }

    public function ppk()
    {
        return $this->belongsTo(RefPPK::class, 'user_id', 'nip');
    }
}
