<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Rules\KurdishChars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{

    public function show()
    {


        return Book::with('chapters')->get();

    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['unique:books,name', 'required', new KurdishChars]
        ]);

        if ($validator->fails()) return response()->json(["errors" => $validator->errors()->all()], 422);

        $newBokk = Book::create([
            'name' => $request->get('name')
        ]);

        return ['success' => "Book added successfully", 'book' => $newBokk];
    }
}
