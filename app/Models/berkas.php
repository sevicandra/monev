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

    public function scopePpk()
    {
        return $this->where('kodeberkas', '01')->orwhere('kodeberkas', '02');
    }

    public function scopeKeuangan()
    {
        return $this->where('kodeberkas', '03')->orwhere('kodeberkas', '04');
    }

    public function scopeBendahara()
    {
        return $this->where('kodeberkas', '03')->orwhere('kodeberkas', '04')->orwhere('kodeberkas', '05');
    }
}
