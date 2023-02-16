<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileViewController extends Controller
{
    public function view($path, $file)
    {
        return response()->file(Storage::path($path.'/'.$file),[
            'Content-Type' => 'application/pdf',
        ]);
    }
}
