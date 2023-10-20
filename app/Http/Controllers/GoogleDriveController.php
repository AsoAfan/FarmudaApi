<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Drive;


class GoogleDriveController extends Controller
{
    protected $googleClient;
    protected $googleDrive;

    public function __construct(Google_Client $googleClient, Google_Service_Drive $googleDrive)
    {
        $this->googleClient = $googleClient;
        $this->googleDrive = $googleDrive;
    }

    public function listFiles()
    {
        $files = $this->googleDrive->files->listFiles();
        return response()->json($files);
    }
}
