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
}
