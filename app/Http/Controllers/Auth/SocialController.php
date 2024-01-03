<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SocialController extends Controller
{
    /*    public function google()
        {
            /*
                    return Socialite::driver('google')->setScopes(['openid', 'email'])
                        ->redirect();
            //        return Socialite::driver('google')
            //            ->stateless()
            //            ->redirect()
            //            ->getTargetUrl();
        }*/


//    public function callback()
//    {
//        $socialUser = Socialite::driver('google')->stateless()->user();
//        $user = $this->findOrCreate($socialUser);
//
//        return $user;

//        return [
//            'success' => 'login succeed',
//            'data' => ['user' => $user, 'token' => $user->createToken('API_TOKEN')->plainTextToken]
//        ];
//    }


    private function google(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'name' => ['required', 'string'],
            'email' => ['required', 'email', 'unique:users,email'],
            'gender' => ['required', 'in:male,female']
        ]);

        if ($validator->fails()) return response(["errors" => $validator->errors()->all()], 400);


        $user = User::where('email', $request->get('email'))->first();

        if (!$user) {
            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'image_name' => $request->get('imageName'),
                'profile_image' => $request->get('profileImage'),
                'gender' => $request->get('gender'),
                'email_verified_at' => now(),
            ]);
        }

        return [
            'success' => 'login succeed',
            'data' => ['user' => $user, 'token' => $user->createToken('API_TOKEN')->plainTextToken]
        ];

    }
}
