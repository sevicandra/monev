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

            $response = Http::asForm()->post(config('sso.base_uri').config('sso.token')['endpoint'],[
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
                $response2 = Http::asForm()->post(config('sso.base_uri').config('sso.userinfo')['endpoint'],[
                    'access_token' => $access_token
                ]);

                if ($response2) {
                    $userinfo =  json_decode($response2->getBody()->getContents(), true);
                    $nip = $userinfo['nip'];
                    $user=User::where('nip', $nip)->first();
                    if (isset($user->id)) {
                        Auth::loginUsingId($user->id);
                        $request->session()->regenerate();
                        $request->session()->put('tahun', date('Y'));
                        $request->session()->put('nik', $userinfo['g2c_Nik']);
                        return redirect()->intended('/dashboard');
                    }
                    return redirect('/')->with('gagal','Pengguna tidak terdaftar');
                } else {
                    redirect('/')->with('gagal','Request Error');
                }
            }else{
                redirect('/')->with('gagal','Request Error');
            }
        }else{
            redirect('/')->with('gagal','Request Error');
        }
    }
}
