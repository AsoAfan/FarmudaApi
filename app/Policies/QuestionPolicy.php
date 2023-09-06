<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class QuestionPolicy
{


    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Question $question): bool
    {
//        dd($user->id, $question->user_id);
        return $user->id === $question->user_id;

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Question $question): bool
    {
        return $user->id === $question->user_id || $user->role === 'admin';

    }

}
