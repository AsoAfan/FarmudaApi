<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Notifications\RoleChangedNotification;
use App\Notifications\WarningNotification;
use App\Services\PaginationService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PaginationService $paginator)
    {


//        dd("User Controller");
        return $paginator->paginate(User::query());
    }


    public function current()
    {
//        dd(new UserResource(Auth::user()));
        return [new UserResource(Auth::user())];
    }


    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return $user;
    }

    public function count()
    {
        $genderCounts = User::groupBy('gender')
            ->selectRaw('gender, COUNT(*) as count')
            ->pluck('count', 'gender');

        return ['males' => $genderCounts['male'], 'females' => $genderCounts['female']];

    }

    public function warn(User $user, Request $request)
    {
        $user->notify(new WarningNotification($user->name, $request->get('message') ?? "Please be careful"));
        return ['success' => $user->name . " warned"];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request) // Password not implemented
    {
        $user = auth()->user();
        $is_allowed = Gate::check('update', $user);
        if (!$is_allowed) return response(['errors' => ['unauthorized']], 400);


        $validator = Validator::make($request->all(), [
            'profileImage' => 'unique:users,profile_image',
            'imageName' => 'string|required_with:profileImage', // TODO: Validate image_type
            'name' => 'string',
            'email' => 'email|unique:users,email,' . $user->email,
            'gender' => 'in:male,female'
        ]);
        if ($validator->fails()) return response(['errors' => $validator->errors()->all()], 400);


//        Can be better by using $request->input(field_value, default_value)
        $user->update([
            'profile_image' => $request->get('profileImage') ?? $user->profile_image,
            'name' => $request->get('name') ?? $user->name,
            'email' => $request->get('email') ?? $user->email,
            'gender' => $request->get('gender') ?? $user->gender,
            'email_verified_at' => $request->has('email') ? null : $user->email_verified_at
        ]);


        return ['success' => "user updated successfully", 'data' => $user->fresh()];

    }

    public function updateRole(Request $request, User $user)
    {
//        $validator = Validator::make(array_map('strtolower', $request->all()), [
//            'role' => ['string', 'in:user,guider,editor,admin']
//        ]);


//        dd(Auth::user()->notifications()->first()->data['user_id']);

//dd(Auth::user()->notifications()->findOrFail($request->get('notification_id'))->data);

        $notification = Auth::user()->notifications()->findOr(
            $request->get('notification_id'),
            fn() => abort(400, "Invalid notification id")
        );
        $user_id = $notification->data['user_id'];
        $role = $notification->data['user_role'];

//        dd($user_id);

        if (!($request->user_id === $user_id)) return response(['errors' => ['Process can not be done']], 400);
        // can be modified to one if because action same for both
        if (!($request->role == $role)) return response(['errors' => ['Process can not be done']], 400);

        if ($user->role === $request->role) return ["success" => "Nothing to do {$user->name} is already {$request->role}", "statues" => 200];

        // TODO: If denied: delete notification as nothing happen

//        if ($validator->fails()) return response()->json(['errors' => $validator->errors()->all(), 'status' => 406], 406);
//        Mail::to(User::where('role', "admin")->get());
        $f_role = $user->role;
        $user->role = $request->role;
        $user->save();

        $user->notify(new RoleChangedNotification($user->name, $f_role));
//        $user->notify(new WarningNotification());

        return [
            "username" => $user->name,
            "previousRole" => $f_role,
            "newRole" => $user->role,
            'success' => "Role of {$user->name} Updated from {$f_role} to {$user->role}",
        ];

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        $is_allowed = Gate::check('delete', $user);
        if (!$is_allowed) return response(['errors' => ['unauthorized']], 400);

        $delete = $user->delete();
        if ($delete) return response(['errors' => ['An error occurred while deleting user']], 400);

        return ['success' => $user->name . "deleted successfully", 'data' => $user->id];
    }

    public function forceDestroy(User $user)
    {
        $is_allowed = Gate::check('delete', $user);
        if (!$is_allowed) return response(['errors' => ['unauthorized']], 400);

        $user->forceDelete();
        return ['success' => $user->name . ' deleted permanently'];


    }
}
