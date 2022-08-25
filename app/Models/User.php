<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Uuids;
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'nip',
        'satker',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function satker(){
        return $this->belongsTo(satker::class, 'satker','kodesatker');
    }

    public function role(){
        return $this->belongsToMany(role::class);
    }

    public function is($access){
        foreach($this->role()->get() as $role){
            if ($role->koderole === $access) {
                return true;
            }
        }
        return false;
    }

    public function scopePegawaisatker($data){
        return $data->where('satker', auth()->user()->satker);
    }

    public function scopePpk($data){
        return $data->wherehas('role', function($val){
            $val->where('koderole', '05');
        });
    }

    public function paguppk()
    {
        return $this->belongsToMany(pagu::class, 'mapingpaguppks');
    }

    public function stafppk()
    {
        return $this->belongsToMany(User::class, 'mapingstafppks', 'ppk_id', 'staf_id');
    }

    public function mapingstafppk()
    {
        return $this->hasOne(mapingstafppk::class, 'staf_id');
    }
    
    public function scopeStafnoppk($data)
    {
        $data->wherehas('role', function($val){
            $val->where('koderole', '06');
        })->doesntHave('mapingstafppk');
    }
    
}
