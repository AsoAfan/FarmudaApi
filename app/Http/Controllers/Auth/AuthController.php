<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailOtp;
use App\Mail\OTP;
use App\Models\User;
use App\Rules\KurdishChars;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{


    public function register(Request $request)
    {


        $validator = Validator::make($request->all(), [

            'name' => ['required', 'string', new KurdishChars],
            'email' => ['required', 'unique:users,email'],
            'password' => ['required', 'min:8', Password::default()]
        ]);

        if ($validator->fails()) return response()->json(["errors" => $validator->errors()->all()]);

        $newUser = User::create([
            "name" => $request->get('name'),
            "email" => $request->get('email'),
            "password" => $request->get('password')
        ]);

        // TODO: Check for internet connection

        if ($newUser) {
            $this->sendOtp(user:$newUser);
        }


    }

    public function sendOtp(Request $request, $user = null)
    {


        if (!$user) $user = User::where('email', $request->get('email'))->first();


        if ($user->email_verified_at) return ['errors' => $user->email . ' is verified with username: ' . $user->name];
        $otp = mt_rand(100000, 999999);
        Mail::to($user->email)->send(new OTP($user->username, $otp));
        $hashedOtp = Hash::make($otp);
//       dd($hashedOtp);
        $user->update([
            'otp_secret' => $hashedOtp,
            'otp_secret_slug' => Str::slug($hashedOtp),
            'otp_expires_at' => now()->addMinutes(5),
        ]);

        return ['success' => "Email sent", "otpHashedSlug" => $user->otp_secret_slug];
    }

    public function login(Request $request)
    {


//        dd(csrf_token());


        $validator = Validator::make($request->all(), [

            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if ($validator->fails()) return response()->json(["errors" => $validator->errors()->all()]);

        $user = User::where('email', $request->email)->first();

        if (!$user->email_verified_at) return response()->json(['errors' => "verify email first", 'user_email' => $user->email], 401);


        if (!Auth::attempt($request->only(['email', 'password']))) return ['errors' => "Invalid credentials"];

        return ['token' => $user->createToken("API_TOKEN")->plainTextToken, "user" => $user];
    }

    public function logout()
    {

        $userName = auth()->user()->name;
        auth()->user()->tokens()->each(function ($token) {
            $token->delete();
        });

        return ['success' => $userName . " Logged out successfully"];

    }
}
