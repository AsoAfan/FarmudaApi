<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Rules\ArabicChars;
use App\Rules\SlugValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    //

    public function index()
    {
        return Book::with("chapters.hadises")->get();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => ["required", "unique:books,name", new ArabicChars],
            "slug" => ['required', 'unique:books,slug', new SlugValidator]
        ]);

        if ($validator->fails()) return ['errors' => $validator->errors()->all()];

        $newBook = Book::create($request->all());

        return ['success' => "Book successfully created", 'newBook' => $newBook];
    }

    public function update(Book $book, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => ["required_without:slug", "unique:books,name,$book->id", new ArabicChars],
            "slug" => ["required_without:name", "unique:books,slug,$book->id", new SlugValidator]
        ]);

        if ($validator->fails()) return response()->json(["errors" => $validator->errors()->all()], 422);

        $book->update($request->all());

        return ["success" => "Book updated successfully", "newBook" => $book];
    }

    public function destroy(Book $book, Request $request)
    {
        $book->delete();

        return ["success" => "$book->name successfully deleted"];
    }
}
