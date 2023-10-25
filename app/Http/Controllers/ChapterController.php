<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Rules\ArabicChars;
use App\Rules\KurdishChars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Chapter::with('books:id,name')->get();

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'name' => ['required', 'unique:chapters,name', new ArabicChars],
            'book_ids' => ['required', 'exists:books,id']
        ]);

        if ($validator->fails()) return response(['errors' => $validator->errors()->all()], 400);


        $newChapter = Chapter::create([
                'name' => $request->get('name')
            ]
        );

        $newChapter->books()->attach($request->get('book_id'));

        return ["success" => "Chapter added successfully", "data" => $newChapter];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chapter $chapter)
    {
        //

        $validator = Validator::make($request->all(), [
            'name' => ['required_without:book_id', "unique:chapters,name,{$chapter->id}", new KurdishChars],
            'book_ids' => ['required' ,'array', 'exists:books,id', 'required_without:name']
        ]);

        if ($validator->fails()) return response(["errors" => $validator->errors()->all()], 400);


        $chapter->books()->sync($request->get('book_ids') ?? []);
        $chapter->update($request->only('name'));

        return ["success" => "chapter updated successfully", 'data' => $chapter];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chapter $chapter)
    {
        //
        $delete = $chapter->delete();
        if (!$delete) return response(['errors' => 'An error occured while deleting chapter'], 400);

        return ['success' => $chapter->name . " deleted successfully", 'data' => $chapter->id];
    }
}
