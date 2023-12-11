<?php

namespace App\Observers;

use App\Models\Answer;

class AnswerObserver
{
    public function created(Answer $answer)
    {

        $answer->activities()->create([
            'action' => "answer for question_id:" . $answer->question_id,
            "data" => json_encode($answer),
            'user_id' => auth()->id()
        ]);


    }
}
