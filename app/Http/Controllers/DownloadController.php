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
        DB::unprepared('FLUSH TABLES WITH READ LOCK;');
        Artisan::queue('backup:run');

        // Get the output of the command (you can use this for debugging)
        $output = Artisan::output();

        // You can also check the exit code if needed
        $exitCode = Artisan::output();

        // You can return a response or redirect to a specific route after running the command
        DB::unprepared('UNLOCK TABLES');
            return $output;
//                                     dd(now()->format('Y-m-d-H-i-s'));                 2023-10-27-02-15-24
//          Storage::download("Laravel/" . now()->format('Y-m-d-H-i-s') . ".zip");
//        return Storage::delete("Laravel/" . now()->format('Y-m-d-H-i-s') . ".zip");
    }
}
