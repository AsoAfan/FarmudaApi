<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;

class EmailVerificationController extends Controller
{
    public function checkOtp(User $user, Request $request)
    {
//        if (!$user->otp_attempt_count <= 3 ) return ['errors' => 'a lot of failed attempts please try again after 24h'];

        if ($user->otp_expires_at > now()) return response()->json(['errors' => "Otp expired"], 403);

        $validator = Validator::make([$request->get('otp_code')], [
            "otp_code" => 'required|numeric|min:6|max:6'
        ]);


//        dd($request->get('otp_code'));
        if (Hash::check($request->get('otp_code'), $user->otp_secret)) {
//            dd($user);
            $user->update([
                'email_verified_at' => now(),
                'otp_secret' => null,
                'otp_expires_at' => null,
                'otp_secret_slug' => null
            ]);
        }
        else {
            $user->increment('otp_attempt_count');
            return ['errors' => "Invalid OTP code"];
        }

    }
}
