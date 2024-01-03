<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AnswerController extends Controller
{
    function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
                'body' => ['required', 'string', 'min:5'],
                'question_id' => ['required', 'exists:questions,id'],
                'category_id' => ['required', 'exists:categories,id']
            ]
        );

        if ($validator->fails()) return response(['errors' => $validator->errors()->all()], 400);

        try {

            $newAnswer = Answer::create([
                'body' => $request->get('body'),
                'question_id' => $request->get('question_id')
            ]);
            $newAnswer->question()->update([
                'category_id' => $request->get('category_id')
            ]);


        } catch (UniqueConstraintViolationException) {
            return response(['errors' => "Question already answered"], 400);
        }
        return ['success' => "Answer stored successfully", 'data' => $newAnswer];

    }
}
