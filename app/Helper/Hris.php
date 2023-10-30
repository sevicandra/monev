<?php

namespace App\Helper;
use Illuminate\Support\Facades\Http;
class Hris
{
    public static function token()
    {
        $token= Http::asForm()->post(config('hris.token_uri'),[
            'client_secret'=>config('hris.secret'),
            'client_id' =>config('hris.id'),
            'grant_type'=>config('hris.grant')
        ]);
        return json_decode($token, false)->access_token;
    }
    
    public static function getRekening($nip)
    {
        $accesstoken = self::token();
        $pegawai = Http::withToken($accesstoken)->get(config('hris.uri').'rekening/Riwayat/GetRekeningByNip/'.$nip);
        return collect(json_decode($pegawai, false)->Data);
    }
}