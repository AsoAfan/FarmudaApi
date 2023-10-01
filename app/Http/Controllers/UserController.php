<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Notifications\RoleChangedNotification;
use App\Notifications\WarningNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::with(['questions'])->get(['id', 'name', 'email', 'role', 'created_at']);
    }


    public function current()
    {
        return auth()->user()->with('favourites.hadis')->find(auth()->id());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // Done in \App\Http\Controllers\Auth\AuthController
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return [$user];
    }

    public function warn(User $user)
    {
        $user->notify(new WarningNotification($user->name));
        return response(['success' => $user->name . " warned", 'status' => 200]);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    public function updateRole(Request $request, User $user)
    {
        $validator = Validator::make(array_map('strtolower', $request->all()), [
            'role' => ['string', 'in:user,guider,editor,admin']
        ]);


        if ($user->role === $request->role) return ["success" => "Nothing to do {$user->name} is already {$request->role}", "statues" => 200];

        if ($validator->fails()) return response()->json(['errors' => $validator->errors()->all(), 'status' => 406], 406);
        $f_role = $user->role;
        $user->role = $request->role;
        $user->save();

        $user->notify(new RoleChangedNotification($user->name, $f_role));
        $user->notify(new WarningNotification());

        return [
            'success' => "Role of {$user->name} Updated from {$f_role} to {$user->role}", 'status' => 200
        ];

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
