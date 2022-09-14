<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class satker extends Model
{
    use Uuids;
    use HasFactory;
    
    protected $fillable = [
        'kodesatker',
        'kodesatkerkoordinator',
        'namasatker',
    ];

    public function user(){
        return $this->hasMany(User::class, 'satker', 'kodesatker');
    }

    public function unit()
    {
        return $this->hasMany(unit::class, 'kodesatker', 'kodesatker');
    }

    public function scopeSearch($data)
    {
        if (request('search')) {

            return $data->where('kodesatker', 'like', '%'.request('search').'%')
                        ->orwhere('namasatker', 'like', '%'.request('search').'%');
        }
    }
}
