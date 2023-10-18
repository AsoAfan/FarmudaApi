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
        return  Book::all();
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "name" => ["required", "unique:books,name", new ArabicChars],
        ]);

        if ($validator->fails()) return response(['errors' => $validator->errors()->all()], 400);

        return ['success' => "Book successfully created"];


        $newBook = Book::create($request->all());

    }

    public function update(Book $book, Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => ["unique:books,name,$book->id", new ArabicChars],

        ]);

        if ($validator->fails()) return response(["errors" => $validator->errors()->all()], 400);

        $book->update($request->all());

        return ["success" => "Book updated successfully", "data" => $book];
    }

    public function destroy(Book $book)
    {
       $delete =  $book->delete();

       if (!$delete) return response(['errors' => 'An error occurred while deleting '], 400);

        return ["success" => "$book->name successfully deleted", 'data' => $book->id];
    }
}
