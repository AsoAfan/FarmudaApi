<?php

namespace App\Http\Controllers;

use App\Models\chapter;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    //

    public function show()
    {
        return chapter::with('books')->get();
    }

    public function store()
    {



    }
}
