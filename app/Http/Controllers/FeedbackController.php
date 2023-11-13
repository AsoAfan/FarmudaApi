<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackStoreRequest;
use App\Models\Feedback;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{

    public function index()
    {

        $page = request('page');
        $take = 20;

        return Feedback::with('user')->skip($page * $take)
            ->take($take)->get();

    }

    public function store(FeedbackStoreRequest $request)
    {

        Feedback::create([
            // this can be in another way => [...$request->only(['body', 'subject']), 'user_id => Auth::id()]
            'subject' => $request->get('subject'),
            'body' => $request->get('body'),
            'user_id' => Auth::id()
        ]);

        return ["success" => 'Feedback submitted successfully'];

    }


    public function delete(Feedback $feedback)
    {
        $feedback->delete();

        return ['success' => "feedback done"];


    }

    public function destroy(Feedback $feedback)
    {

        $feedback->forceDelete();

        return ['success' => 'feedback deleted successfully'];

    }

}
