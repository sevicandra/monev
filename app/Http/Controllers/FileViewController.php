<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class FileViewController extends Controller
{
    public function view($path, $file)
    {
        if (explode('.', $file)[1] == 'pdf') {
            return response()->file(Storage::path($path.'/'.$file),[
                'Content-Type' => 'application/pdf',
            ]);
        }elseif (explode('.', $file)[1] == 'xlsx') {
            return response()->file(Storage::path($path.'/'.$file),[
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]);
        }elseif(explode('.', $file)[1] == 'xls'){
            return response()->file(Storage::path($path.'/'.$file),[
                'Content-Type' => 'application/vnd.ms-excel',
            ]);
        }elseif(explode('.', $file)[1] == 'zip'){
            return response()->file(Storage::path($path.'/'.$file),[
                'Content-Type' => 'application/zip',
            ]);
        }elseif(explode('.', $file)[1] == 'rar'){
            return response()->file(Storage::path($path.'/'.$file),[
                'Content-Type' => 'application/x-rar-compressed',
            ]);
        }
    }
}
