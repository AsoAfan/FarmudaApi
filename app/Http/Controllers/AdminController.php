<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\PromotionNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //
    private $admins;

    public function __construct()
    {
        $this->admins = User::where('role', 'admin');
    }


    public function index()
    {
        return $this->admins->get();
    }

    public function promoteRequest(User $user, Request $request)
    {

        $validator = Validator::make(array_map('strtolower', $request->all()), [
            'role' => ['string', 'in:user,guider,editor,admin']
        ]);

        if ($validator->fails()) return response(
            [
                'errors' => $validator->errors()->all()
            ],
            400);


//        $admins = User::where('role', 'admin')->where('id', Auth::id())->toSql();
//        Log::info(User::where('role', 'admin')->toSql());
//        Which one is better using reject function on collection instance or one additional where

        $admin = Auth::user();
        $admins = $this->admins->where('id', '!=', Auth::id())->get();
        Notification::send($admins,
            new PromotionNotification(
                admin: $admin->name,
                user: $user->name,
                user_id: Hash::make($user->id),
                o_role: $user->role,
                role: $request->get('role')
            ));

        return ['success' => 'Notification sent successfully'];


    }
}
