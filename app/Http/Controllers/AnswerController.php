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
            'question_id' => ['required', 'exists:questions,id']
        ]);

        if ($validator->fails()) return response(['errors' => $validator->errors()->all()], 400);

        try {
            $newAnswer = Answer::create([
                'body' => $request->get('body'),
                'question_id' => $request->get('question_id')
            ]);

        } catch (UniqueConstraintViolationException $e) {
            return ['errors' => "Question already answered"];
        }
        return ['success' => "Answer stored successfully", 'data' => $newAnswer];

    }
}
