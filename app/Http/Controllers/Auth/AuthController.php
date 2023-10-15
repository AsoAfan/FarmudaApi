<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\EmailOtp;
use App\Mail\OTP;
use App\Models\User;
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

            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'gender' => ['required', 'in:male,female'],
            'password' => ['required', 'min:8', 'confirmed', Password::default()],
            'password_confirmation' => ['required']
        ]);

        if ($validator->fails()) return response()->json(["errors" => $validator->errors()->all()]);


        $newUser = User::create([
            "name" => $request->get('name'),
            "email" => $request->get('email'),
            "gender" => $request->get('gender'),
            "password" => $request->get('password')
        ]);

        // TODO: Check for internet connection
        if ($newUser)
            return $this->sendOtp($newUser);


        return response()->json(['errors' => "An error occurred while sending email", 'status' => response()->status()], response()->status());

    }

    public function sendOtp($user = null)
    {

        $user = $user ?: User::where('email', request('email'))->first();

        if (!$user) return response()->json(['errors' => request()->get('email') . " not associated with any user", 'status' => 404], 404);

        if ($user->email_verified_at) return ['errors' => $user->email . ' is verified with username: ' . $user->name];

//                                        TODO:can be better in feature
        if ($user->otp_attempt_count > config('myApp.max_otp_attempts', 3)) return response()->json(['errors' => 'a lot of requests received please try again tomorrow', "status" => 403], 403);

        $otp = mt_rand(100000, 999999);
//        \Illuminate\Support\Facades\Log::info("OTP Sent");
        Mail::to($user->email)->send(new OTP($user->username, $otp));
        $otp = Hash::make($otp);
//       dd($hashedOtp);
        $user->update([
            'otp_secret' => $otp,
            'otp_secret_slug' => Str::slug($otp),
            'otp_expires_at' => now()->addMinutes(config('myApp.otp_expiry_minutes', 5)),
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

        if ($user && !$user->email_verified_at) return response()->json(['errors' => "verify email first", 'user_email' => $user->email], 401);


        if (!Auth::attempt($request->only(['email', 'password']))) return ['errors' => "Invalid credentials"];

        return ['success' => "Token generated successfully", 'data' =>['token' => $user->createToken("API_TOKEN")->plainTextToken, "user" => $user]];
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
