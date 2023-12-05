<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

class SocialController extends Controller
{
    public function google()
    {
        return Socialite::driver('google')
            ->stateless()
            ->redirect()
            ->getTargetUrl();
    }



    public function callback()
    {
        $socialUser = Socialite::driver('google')->stateless()->user();
        $user = $this->findOrCreate($socialUser);


        return [
            'success' => 'login succeed',
            'data' => ['user' => $user, 'token' => $user->createToken('API_TOKEN')->plainTextToken]
        ];
    }


    private function findOrCreate($user)
    {
        $existUser = User::where('email', $user->getEmail())->first();

        if ($existUser) {
            return $existUser;
        } else {
            return User::create([
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'email_verified_at' => now(),
                'role' => 'user',
            ]);
        }
    }
}
