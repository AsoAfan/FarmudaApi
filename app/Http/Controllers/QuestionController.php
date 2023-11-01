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

        return Question::with(['user', 'answer'])->get();

    }


    public function current(): array
    {
        return auth()->user()->questions()->first();
//        return  Question::where('user_id', auth()->id());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
//        $this->authorize('create', Question::class);

        $validator = Validator::make($request->all(), [
            'body' => ['required', 'min:10', new KurdishOrArabicChars]
        ]);


        if ($validator->fails())
            return response([
                'errors' => $validator->errors()->all(),
            ], 400
            );

        $newQuestion = Question::create([
            'body' => $request->get('body'),
            'user_id' => auth()->id()
        ]);

        return ['success' => "{$newQuestion->user->name}'s question added successfully", 'data' => $newQuestion];
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
        $auth = Gate::check('update', $question);
        if (!$auth->allowed()) return response(['errors' => "Unauthorized user"], 400);


        $validator = Validator::make($request->all(), [
            'body' => ['min:10', new KurdishOrArabicChars]
        ]);

        if ($validator->fails()) return response(['errors' => $validator->errors()->all()], 400);

        $question->update(
            $request->only('body')
        );

        return ['success' => "Question updated successfully", 'data' => $question];
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $auth = Gate::check('delete', $question);
        if (!$auth->allowed()) return response(['errors' => "Unauthorized user"], 400);


        $delete = $question->delete();
        if (!$delete) return response(['errors' => ['An occurred while deleting question']], 400);

        return ['success' => $question->body . " has been deleted successfully", 'data' => $question->id];
    }
}
