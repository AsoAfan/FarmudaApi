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

        try {
            $a = (File::files(storage_path()));
            $b = (File::directories(public_path()));
            $b = (File::directories(storage_path(). '/app'));
//            dd($b);
            return ["storage_path" => $a, "storage.app_path" => $b];

        }catch (\Exception $e){
            return ['errors' => $e->getMessage()];
        }
//                                     dd(now()->format('Y-m-d-H-i-s'));                 2023-10-27-02-15-24
//          Storage::download("Laravel/" . now()->format('Y-m-d-H-i-s') . ".zip");
//        return Storage::delete("Laravel/" . now()->format('Y-m-d-H-i-s') . ".zip");
    }
}
