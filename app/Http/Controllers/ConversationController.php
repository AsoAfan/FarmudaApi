<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;

class ConversationController extends Controller
{
    //

    public function store(User $user, Request $request)
    {
        $conversation = Conversation::where()
    }
}
