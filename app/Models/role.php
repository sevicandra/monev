<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class role extends Model
{
    use Uuids;
    use HasFactory;

    protected $fillable = [
        'koderole',
        'role',
    ];

    public function user()
    {
        return $this->belongsToMany(User::class);
    }

    public function scopeOfUser($data, $user)
    {

        function searchuser($val, $user){
            $val->where('id', $user);
        }

        return $data->doesntHave('User', searchuser($this, $user))->get();
    }
}
