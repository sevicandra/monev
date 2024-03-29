<?php

namespace App\Helper;

use stdClass;
use App\Models\Payroll;
use App\Models\tagihan;
use App\Models\RefStafPPK;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;

class Notification
{
    public function tagihan()
    {
        return tagihan::where('status', 0)->TagihanNonBLBI()->tagihanStafPPK()->count();
    }

    public function tagihanBlbi()
    {
        return tagihan::where('status', 0)->tagihanBLBI()->tagihanStafPPK()->count();
    }

    public function verifikasi()
    {
        return tagihan::tagihansatker()->tagihanverifikator()->unverified()->count();
    }

    public function verifikasiKKP()
    {
        return tagihan::tagihansatker()->tagihanverifikatorKKP()->unverified()->count();
    }

    public function bendahara()
    {
        return tagihan::tagihansatker()->bendahara()->count();
    }

    public function payroll()
    {
        return Payroll::BelumTransferCount()->count();
    }

    public function ppspm()
    {
        return tagihan::tagihansatker()->ppspm()->count();
    }
    public static function Notif()
    {
        $notificationInstance = new self(); // create an instance of Notification

        $notif = new stdClass;

        if (Gate::allows('Staf_PPK')) {
            $notif->tagihan = $notificationInstance->tagihan();
            if (session()->get('staf_ppk_blbi') == 1) {
                $notif->tagihanBlbi = $notificationInstance->tagihanBlbi();
            }
        }

        if (Gate::allows('Validator')) {
            $notif->verifikasi = $notificationInstance->verifikasi();
        }

        if (Gate::allows('Bendahara')) {
            $notif->bendahara = $notificationInstance->bendahara();
            $notif->payroll = $notificationInstance->payroll();
        }

        if (Gate::allows('PPSPM')) {
            $notif->ppspm = $notificationInstance->ppspm();
        }

        if (Gate::allows('ValidatorKKP')) {
            $notif->verifikasiKKP = $notificationInstance->verifikasiKKP();
        }

        return $notif;
    }
}
