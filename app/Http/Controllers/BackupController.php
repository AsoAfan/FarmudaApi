<?php

namespace App\Http\Controllers;

use App\Models\Hadith;

class BackupController extends Controller
{
    //

    public function hadith()
    {
        $hadiths = Hadith::all();
        $jsonData = json_encode($hadiths, JSON_PRETTY_PRINT);

        $filename = 'export_hadiths_' . now()->format('YmdHis') . '.json';

        // Save JSON data to a file
        file_put_contents(storage_path('app/' . $filename), $jsonData);

        // Generate a response to download the file
        return response()->download(storage_path('app/' . $filename), $filename)->deleteFileAfterSend();
    }
}
