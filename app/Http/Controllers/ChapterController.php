<?php

namespace App\Http\Controllers;

use App\Models\Chapter;
use App\Rules\ArabicChars;
use App\Rules\KurdishChars;
use App\Rules\SlugValidator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ChapterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Chapter::with('hadises')->get();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(request()->all(), [
            'name' => ['required', 'unique:chapters,name', new ArabicChars],
            'slug' => ['required', 'unique:chapters,slug', new SlugValidator],
            'book_id' => ['required', 'exists:books,id']
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->errors()->all()]);


        $newChapter = Chapter::create([
                'name' => $request->get('name'),
                'slug' => $request->get('slug')
            ]
        );

        $newChapter->books()->attach($request->get('book_id'));

        return ["success" => "Chapter added successfully", "newChapter" => $newChapter];
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Chapter $chapter)
    {
        //

        $validator = Validator::make($request->all(), [
            'name' => ['required_without:slug', "unique:chapters,name,{$chapter->id}", new KurdishChars],
            'slug' => ['required_without:name', "unique:chapters,name,{$chapter->id}", new SlugValidator]
        ]);

        if ($validator->fails()) return ["errors" => $validator->errors()->all()];


        $chapter->update($request->all());

        return ["success" => "chapter updated successfully", 'newChapter' => $chapter];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Chapter $chapter)
    {
        //
        $chapter->delete();
        return ['success' => $chapter->name . " deleted successfully"];
    }
}
