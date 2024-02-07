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


    public function satker()
    {
        return $this->belongsTo(satker::class, 'satker', 'kodesatker');
    }

    public function role()
    {
        return $this->belongsToMany(role::class, 'role_user', 'user_id', 'role_id', 'nip', 'koderole');
    }

    public function ppk()
    {
        return $this->hasMany(RefPPK::class, 'nip', 'nip');
    }

    public function is($access)
    {
        foreach ($this->role()->get() as $role) {
            if ($role->koderole === $access) {
                return true;
            }
        }
        return false;
    }

    public function isPpk()
    {
        if ($this->ppk()->first()) {
            return true;
        }
        return false;
    }

    public function scopePegawaisatker($data)
    {
        return $data->where('satker', auth()->user()->satker);
    }
    public function scopePpk($data)
    {
        return $data->wherehas('role', function ($val) {
            $val->where('koderole', '05');
        });
    }
    public function scopeStafppk($data)
    {
        return $data->wherehas('role', function ($val) {
            $val->where('koderole', '06');
        });
    }

    public function paguppk()
    {
        return $this->belongsToMany(pagu::class, 'mapingpaguppks', 'user_id', 'pagu_id', 'nip', 'id')->where('tahun', session()->get('tahun'));
    }

    public function realisasippk()
    {
        $realisasi = realisasi::join('pagus', 'pagus.id', '=', 'realisasis.pagu_id')->where('tahun', session()->get('tahun'))->join('mapingpaguppks', 'pagus.id', '=', 'mapingpaguppks.pagu_id')->sp2d()
            ->join('users', 'mapingpaguppks.user_id', '=', 'users.nip')->leftjoin('sspbs', 'sspbs.realisasi_id', '=', 'realisasis.id')->where('users.nip', $this->nip);
        if ($realisasi->first()) {
            return $realisasi;
        }
        $real = new Collection();

        $real->push((object)[
            'realisasi' => '0',
        ]);

        return $real;
    }

    public function sspbppk()
    {
        $sspb = sspb::join('pagus', 'pagus.id', '=', 'sspbs.pagu_id')->where('tahun', session()->get('tahun'))->join('mapingpaguppks', 'pagus.id', '=', 'mapingpaguppks.pagu_id')
            ->join('users', 'mapingpaguppks.user_id', '=', 'users.nip')->where('users.nip', $this->nip);

        if ($sspb->first()) {
            return $sspb;
        }
        $real = new Collection();

        $real->push((object)[
            'nominal_sspb' => '0',
        ]);

        return $real;
    }

    public function stafppk()
    {
        return $this->belongsToMany(RefPPK::class, 'mapingstafppks', 'ppk_id', 'staf_id', 'nip', 'nip');
    }

    public function mapingstafppk()
    {
        return $this->hasOne(mapingstafppk::class, 'staf_id', 'nip');
    }

    public function scopeStafnoppk($data)
    {
        $data->wherehas('role', function ($val) {
            $val->where('koderole', '06');
        })->doesntHave('mapingstafppk');
    }

    public function unitstafppk()
    {
        return $this->belongsToMany(unit::class, 'mapingunitstafppks', 'user_id', 'unit_id', 'nip', 'kodeunit');
    }

    public function verifikator()
    {
        return $this->belongsToMany(unit::class, 'verifikatorunits', 'user_id', 'unit_id', 'nip', 'kodeunit');
    }

    public function scopeVerifikator($data){
        return $data->wherehas('role', function($val){
            $val->where('koderole', '09');
        });
    }

    public function scopeVerifikatornonsign($data, $unit)
    {
        $var = $unit;
        return $data->whereDoesntHave('verifikator', function ($val) use ($var) {
            $val->where('id', $var);
        });
    }

    public function verifikatorunit($val)
    {

        foreach ($this->verifikator()->get() as $unit) {
            if ($unit->id === $val) {
                return true;
            }
        }
    }

    public function scopeSearch($data)
    {
        if (request('search')) {
            return $data->where('nama', 'like', '%' . request('search') . '%')
                ->orwhere('nip', 'like', '%' . request('search') . '%');
        }
    }

    public function scopeRealisasiBulanan($data, $ppk_id, $bulan)
    {
        $data->belongsToMany(pagu::class, 'mapingpaguppks')
            ->where('tahun', session()->get('tahun'))
            ->leftJoin('realisasis', 'mapingpaguppks.pagu_id', '=', 'realisasis.pagu_id');
    }
}
