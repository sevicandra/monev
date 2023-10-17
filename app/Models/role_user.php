<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class role_user extends Model
{

    protected $fillable = [
        'user_id',
        'role_id',
    ];

    protected $table = 'role_user';
    public $timestamps = false;

}
