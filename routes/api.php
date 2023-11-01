<?php

use Illuminate\Support\Facades\Route;


//Route::get('send', function () {
//    \Illuminate\Support\Facades\Mail::to('aso.sargaty@yahoo.com')->send(new \App\Mail\OTP("aso afan"));
//});

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


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


    // ADMIN
    require_once __DIR__ . '/api/admin.php';

    // ADMIN_EDITOR
    require_once __DIR__ . '/api/admin_editor.php';

    // AUTH

    require_once __DIR__ . '/api/auth.php';

    // GUEST
    require_once __DIR__ . '/api/guest.php';

    // ALL_USERS

    require_once __DIR__ . '/api/all_users.php';

});


// Tests
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