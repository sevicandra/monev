<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class verifikatorunits extends Model
{

    protected $fillable = [
        'user_id',
        'unit_id',
    ];

    protected $table = 'verifikatorunits';

    public $timestamps = false;
}
