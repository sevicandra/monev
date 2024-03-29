<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\RefStafPPK;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;

class SsoController extends Controller
{
    public function sso()
    {
        return redirect(config('sso.base_uri').config('sso.authorize')['endpoint'].'?grant_type='.config('sso.authorize')['grant_type'].'&response_type='.config('sso.authorize')['response_type'].'&client_id='.config('sso.authorize')['client_id'].'&scope='.config('sso.authorize')['scope'].'&nonce='.  config('sso.authorize')['nonce'].'state='.config('sso.authorize')['state'].'&redirect_uri='.config('sso.authorize')['redirect_uri']);
    }
    public function sign_in(Request $request)
    {
        session()->regenerate();
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
            if(!isset($token['access_token'])){
                return redirect('/sso');
            }
            $access_token = $token['access_token'];
            if ($access_token) {
                $response2 = Http::asForm()->post(config('sso.base_uri').config('sso.userinfo')['endpoint'],[
                    'access_token' => $access_token
                ]);

                if ($response2) {
                    $userinfo =  json_decode($response2->getBody()->getContents(), true);
                    $nip = $userinfo['nip'];
                    $nama = $userinfo['name'];
                    $kode_satker = $userinfo['kode_satker'];
                    $user = User::updateOrCreate([
                        'nip' => $nip,
                    ], [
                        'nama' => $nama,
                        'satker' => $kode_satker,
                    ]);
                 
                    Auth::login($user);
                    $request->session()->regenerate();
                    $request->session()->put('kdsatker', auth()->user()->satker);
                    $request->session()->put('tahun', date('Y'));
                    $request->session()->put('nik', $userinfo['g2c_Nik']);
                    $request->session()->put('id_token', $token['id_token']);
                    $request->session()->put('gravatar', $userinfo['gravatar']);
                    // $request->session()->put('nip', auth()->user()->nip);
                    $role = User::GetRole();
                    $request->session()->put('role', $role);
                    if (Gate::allows('Staf_PPK', auth()->user()->id)) {
                        $ppk = RefStafPPK::getPPK();
                        $request->session()->put('ppk', $ppk);
                        $unit = RefStafPPK::getUnit();
                        $request->session()->put('unit', $unit);
                        $request->session()->put('staf_ppk_blbi', auth()->user()->stafppk->first()->satgasBLBI);
                    }
                    return redirect()->intended('/dashboard');
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
