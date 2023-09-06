<?php

namespace App\Http\Controllers;

use App\Mail\OTP;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class PasswordResetController extends Controller
{
    public function sendResetOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => "required|email"
        ]);

        if ($validator->fails()) return response()->json(['errors' => $validator->errors()->all(), 'status' => 403], 403);


    }

    private function sendOtp($email = "", Request $request)
    {
        $otp = mt_rand(100000, 999999);

        $user = User::where('email', $email ?? $request->get('email'))->first();

        DB::table('password_reset_tokens')->updateOrInsert([
            'email' => $user->email,
            'token' => Hash::make($otp)
        ]);

        Mail::to($email)->send(new OTP($user->username, $otp));

        return response()->json(['success' => "Code for reset password send successfully"]);


    }
}
