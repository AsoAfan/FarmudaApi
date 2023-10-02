<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{

    public function index()
    {
        return auth()->user()->conversations;
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'body' => 'required|string',
            'conversation_id' => 'required|exists:conversations,id'
        ]);

        if ($validator->fails())
            return ["errors" => $validator->errors()->all(), 'status' => 406];

        $newMessage = Message::create([
            'body' => $request->get('body'),
            'conversation_id' => $request->get('conversation_id'),
            'user_id' => auth()->id()
        ]);

        return ['success' => "Message sent", "sentMessage" => $newMessage, 'status' => 200];

    }


}
