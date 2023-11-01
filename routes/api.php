<?php

use Illuminate\Support\Facades\Route;

/*
 *
 * User roles
 * 1. Admins
 * 2. Instructors
 * 3. Auth users
 * 4. All users
 * 5. Guests only (Login, Signup, ...)
 *
 * */


Route::middleware('json')->group(function () {
    require __DIR__ . '/api/admin.php';
    require __DIR__ . '/api/admin_editor.php';
    require __DIR__ . '/api/admin_guider.php';
    require __DIR__ . '/api/guider.php';
    require __DIR__ . '/api/auth.php';
    require __DIR__ . '/api/guest.php';
    require __DIR__ . '/api/all_users.php';
});


// Reference
Route::get('test-poly', function () {
//    $ac = new \App\Models\Activity();
//    $hadis = \App\Models\Hadis::find(1);
//    $ac->user_id = 1;
//   $ac->model()->associate($hadis);
//   $ac->save();
    return ['data' => \App\Models\Activity::with([
            'model' => fn($query) => $query->select('id', 'arabic'),
            'user' => fn($query) => $query->select('id', 'name')
        ]
    )->get()];
});