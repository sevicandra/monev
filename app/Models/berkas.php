<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class berkas extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'kodeberkas',
        'namaberkas',
    ];
}
