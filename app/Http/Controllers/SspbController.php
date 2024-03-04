<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SspbController extends Controller
{
    public function index(){
        if (!Gate::any(['Validator', 'PPSPM', 'Bendahara', 'ValidatorKKP'])) {
            abort(403);
        }

        return view('sspb.index');
    }

    public function create(){
        if (!Gate::any(['Validator', 'PPSPM', 'Bendahara', 'ValidatorKKP'])) {
            abort(403);
        }
    }
}
