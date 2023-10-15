<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use function Sodium\increment;

class EmailVerificationController extends Controller
{

    public function checkOtp(User $user, Request $request)
    {
//                                        TODO:can be better in feature
        if ($user->otp_attempt_count >= config('myApp.max_otp_attempts')) return ['errors' => 'a lot of requests please try again after 24h'];

        if ($user->otp_expires_at < now()) {
            $user->update([
                'otp_secret' => null,
                'otp_attempt_count' => $user->otp_attempt_count++
            ]);
            $user->increment('otp_attempt_count');

            return response()->json(['errors' => "Otp expired"], 403);
        }
        // not-expired code is a code that: expire date is more than current date

        $validator = Validator::make([$request->get('otp_code')], [
            "otp_code" => 'required|numeric|min:6|max:6'
        ]);

        $user->update([
            'latest_otp_attempt' => now()
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
        } else {
            $user->increment('otp_attempt_count');
            return ['errors' => "Invalid OTP code"];
        }


        return response()->json(["success" => "$user->email verified successfully"]);
    }
}
