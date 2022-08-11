<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class dokumen extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'kodedokumen',
        'namadokumen',
        'status'
    ];
}
