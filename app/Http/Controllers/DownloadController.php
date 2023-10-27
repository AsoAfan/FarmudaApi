<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\File;


//use Spatie\Backup\Tasks\Backup\

class DownloadController extends Controller
{
    public function index()
    {

        try {
            $a = (File::files(storage_path()));
            $b = (File::directories(storage_path()));
            $c = (File::directories(public_path()));
            $d = (File::files(public_path()));
            $e = (File::files(storage_path() . '/app'));
            $f = (File::directories(storage_path() . '/app'));
//            dd($b);
            return [
                "storage_files" => $a,
                "storage_directory" => $b,
                "public_directory" => $c,
                "public_files" => $d,
                "storage_app_directory" => $e,
                "storage_app_files" => $f,

            ];

        } catch (\Exception $e) {
            return ['errors' => $e->getMessage()];
        }
//                                     dd(now()->format('Y-m-d-H-i-s'));                 2023-10-27-02-15-24
//          Storage::download("Laravel/" . now()->format('Y-m-d-H-i-s') . ".zip");
//        return Storage::delete("Laravel/" . now()->format('Y-m-d-H-i-s') . ".zip");
    }
}
