<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nominaldnp extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'dnp_id',
        'bruto',
        'pph',
        'netto'
    ];

    public function dnp()
    {
        return $this->belongsTo(dnp::class);
    }
}
