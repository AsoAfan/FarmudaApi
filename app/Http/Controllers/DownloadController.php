<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;


//use Spatie\Backup\Tasks\Backup\

class DownloadController extends Controller
{
    public function index()
    {

        $a = (File::directories(storage_path(). '/app/'. env('APP_NAME')));
        return ["name" => $a];
//                                     dd(now()->format('Y-m-d-H-i-s'));                 2023-10-27-02-15-24
//          Storage::download("Laravel/" . now()->format('Y-m-d-H-i-s') . ".zip");
//        return Storage::delete("Laravel/" . now()->format('Y-m-d-H-i-s') . ".zip");
    }
}
