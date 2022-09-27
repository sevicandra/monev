<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SsoController extends Controller
{
    public function sso()
    {
        return redirect(config('sso.base_uri').config('sso.authorize')['endpoint'].'?grant_type='.config('sso.authorize')['grant_type'].'&response_type='.config('sso.authorize')['response_type'].'&client_id='.config('sso.authorize')['client_id'].'&scope='.config('sso.authorize')['scope'].'&nonce='.  config('sso.authorize')['nonce'].'state='.config('sso.authorize')['state'].'&redirect_uri='.config('sso.authorize')['redirect_uri']);
    }
    public function sign_in(Request $request)
    {
        if ($request->code) {
            // Get Token
            $response = Http::post(config('sso.base_uri').config('sso.token')['endpoint'],[
                'client_id' => config('sso.authorize')['client_id'],
                'grant_type' => config('sso.authorize')['grant_type'],
                'client_secret' => config('sso.token')['client_secret'],
                'code' => $request->code,
                'redirect_uri' => config('sso.authorize')['redirect_uri']
            ]);
            $token =  json_decode($response->getBody()->getContents(), true);
            
            // Get User Info
            $access_token = $token['access_token'];
            if ($access_token) {
                $response = Http::post(config('sso.base_uri').config('sso.userinfo')['endpoint'],[
                    'access_token' => $access_token
                ]);
                if ($response) {
                    $userinfo =  json_decode($response->getBody()->getContents(), true);
                    $nip = $userinfo['nip'];
                    if(Auth::loginUsingId($nip)){
                        $request->session()->regenerate();
                        $request->session()->put('tahun', date('Y'));
                        return redirect()->intended('/dashboard');
                    }
                    return back()->with('LoginErorr','Pengguna tidak terdaftar');
                } else {
                    redirect('welcome');
                }
            }
        }
    }
}
