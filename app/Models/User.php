<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\Uuids;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Collection;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

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
        'id',
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

    public function scopeStafppk($data){
        return $data->wherehas('role', function($val){
            $val->where('koderole', '06');
        });
    }

    public function scopeVerifikator($data){
        return $data->wherehas('role', function($val){
            $val->where('koderole', '09');
        });
    }

    public function paguppk()
    {
        return $this->belongsToMany(pagu::class, 'mapingpaguppks')->where('tahun', session()->get('tahun'));
    }

    public function realisasippk()
    {
        $realisasi= realisasi::join('pagus', 'pagus.id', '=', 'realisasis.pagu_id')->where('tahun', session()->get('tahun'))->join('mapingpaguppks', 'pagus.id', '=', 'mapingpaguppks.pagu_id')->sp2d()
        ->join('users', 'mapingpaguppks.user_id', '=', 'users.id')->where('users.id', $this->id);
        if ($realisasi->first()) {
            return $realisasi;
        }
        $real = new Collection();
        
        $real->push((object)['realisasi' => '0',
        ]);

        return $real;
    }

    public function sspbppk()
    {
        $sspb= sspb::join('pagus', 'pagus.id', '=', 'sspbs.pagu_id')->where('tahun', session()->get('tahun'))->join('mapingpaguppks', 'pagus.id', '=', 'mapingpaguppks.pagu_id')
        ->join('users', 'mapingpaguppks.user_id', '=', 'users.id')->where('users.id', $this->id);

        if ($sspb->first()) {
            return $sspb;
        }
        $real = new Collection();
        
        $real->push((object)['nominal_sspb' => '0',
        ]);

        return $real;
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
    
    public function unitstafppk()
    {
        return $this->belongsToMany(unit::class, 'mapingunitstafppks');
    }

    public function verifikator()
    {
        return $this->belongsToMany(unit::class, 'verifikatorunits');
    }

    public function scopeVerifikatornonsign($data, $unit)
    {
        $var=$unit;
        return $data->whereDoesntHave('verifikator', function($val)use($var){
            $val->where('id', $var);
        });
    }

    public function verifikatorunit($val)
    {
       
        foreach ($this->verifikator()->get() as $unit ) {
            if ($unit->id === $val) {
                return true;
            }
        }
    }

    public function scopeSearch($data)
    {
        if (request('search')) {
            return $data    ->where('nama', 'like', '%'.request('search').'%')
                            ->orwhere('nip', 'like', '%'.request('search').'%');
        }
    }
}
