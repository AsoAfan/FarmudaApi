<?php

namespace App\Http\Controllers;

use App\Http\Requests\FeedbackStoreRequest;
use App\Models\Feedback;
use App\Services\PaginationService;
use Illuminate\Support\Facades\Auth;

class FeedbackController extends Controller
{

    public function index(PaginationService $paginator)
    {


        return $paginator->paginate(
            Feedback::with('user')
        );

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


    public function delete(Feedback $feedback): array
    {
        $feedback->delete();

        return ['success' => "feedback done"];


    }

    public function destroy(Feedback $feedback): array
    {

        $feedback->forceDelete();

        return ['success' => 'feedback deleted successfully'];

    }

}
