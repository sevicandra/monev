<?php

namespace App\Helper;

use stdClass;
use App\Models\Payroll;
use App\Models\tagihan;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;

class Notification
{
    public function tagihan()
    {
        return tagihan::where('status', 0)->where('tahun', session()->get('tahun'))->tagihanppk()->count();
    }

    public function verifikasi()
    {
        return tagihan::tagihansatker()->tagihanverifikator()->unverified()->count();
    }

    public function bendahara()
    {
        return tagihan::tagihansatker()->bendahara()->count();
    }

    public function payroll()
    {
        return Payroll::BelumTransfer()->count();
    }

    public function ppspm()
    {
        return tagihan::tagihansatker()->ppspm()->count();
    }
    public static function Notif()
    {
        $notificationInstance = new self(); // create an instance of Notification

        $notif = new stdClass;

        if (Gate::allows('Staf_PPK', auth()->user()->id)) {
            $notif->tagihan = $notificationInstance->tagihan();
        }

        if (Gate::allows('Validator', auth()->user()->id)) {
            $notif->verifikasi = $notificationInstance->verifikasi();
        }

        if (Gate::allows('Bendahara', auth()->user()->id)) {
            $notif->bendahara = $notificationInstance->bendahara();
            $notif->payroll = $notificationInstance->payroll();
        }

        if (Gate::allows('PPSPM', auth()->user()->id)) {
            $notif->ppspm = $notificationInstance->ppspm();
        }

        return $notif;
    }
}