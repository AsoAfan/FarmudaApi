<?php

namespace App\Http\Controllers\auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    public function sendLink(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'email' => 'required|email'
        ]);

        if ($validator->fails()) return response(['errors' => $validator->errors()->all()], 400);

        $statues = Password::sendResetLink(
            $request->only('email')
        );

        return ['success' => 'password resent link successfully'];

    }

    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->only('email', 'token', 'password'), [
            'email' => 'email|required',
            'token' => 'required',
            'password' => 'required|min:8|confirmed'
        ]);

        if ($validator->fails()) return response(['errors' => $validator->errors()->all()], 400);

        $statues = Password::reset($request->only(
            'email',
            'password',
            'password_confirmation',
            'token'
        ), function (User $user, string $password) {
            $user->forceFill([
                'password' => Hash::make($password)
            ]);
            $user->save();

        });

    }
}
