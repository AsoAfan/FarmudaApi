<?php

namespace App\Http\Controllers;

use App\Models\Question;
use App\Rules\KurdishOrArabicChars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Question::with(['user'])->get();
    }


    public function current()
    {
        return Question::where('user_id', auth()->id());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Question::class);

        $validator = Validator::make($request->all(), [
            'body' => ['required', 'min:10', new KurdishOrArabicChars]
        ]);


        if (empty($validator)) return ['errors' => "Body is required and it must be at least 10 Arabic chars"];

        $newQuestion = Question::create([
            'body' => $request->get('body'),
            'user_id' => auth()->id()
        ]);

        return ['success' => "{$newQuestion->user->name}'s question added successfully"];
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Question $question)
    {
        $auth = Gate::inspect('update', $question);
        if (!$auth->allowed()) return response()->json(['errors' => "Unauthorized user"], 403);


        $validator = Validator::make($request->all(), [
            'body' => ['min:10', new KurdishOrArabicChars]
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->errors()->all()], 422);

        $updatedQuestion = $question->update([
            ...$request->all(),
            'user_id' => $question->user_id
        ]);

        return ['success' => "Question updated successfully", 'updatedQuestion' => $question];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $auth = Gate::inspect('delete', $question);
        if (!$auth->allowed()) return response()->json(['errors' => "Unauthorized user"], 403);


        $question->delete();

        return ['success' => $question->body . " has been deleted successfully"];
    }
}