<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\PromotionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //

    public function promoteRequest(User $user, Request $request)
    {

        $validator = Validator::make(array_map('strtolower', $request->all()), [
            'role' => ['string', 'in:user,guider,editor,admin']
        ]);

        if ($validator->fails()) return response()->json(
            [
                'errors' => $validator->errors()->all(),
                'status' => 406
            ],
            406
        );


        $admin = Auth::user();
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins,
            new PromotionNotification(
                admin: $admin->name,
                user: $user->name,
                o_role: $user->role,
                role: $request->get('role')
            ));

        return ["user_id" => $user->id, 'role' => $request->get('role')];


    }
}
