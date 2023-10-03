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
 *
 * 5. Guest only (Login, Signup, ...)
 *
 * */


//Route::get('/test-cors', function () {
//    return response()->json(['message' => 'CORS test successful']);
//})->middleware('cros');


Route::middleware('json')->group(function () {
    Route::get('test1', function () {
        return ["test" => route('test1')];
    })->name('test1');

    include_once base_path('routes\\api\\admin.php');
    include_once base_path("routes\\api\\admin_editor.php");

    include_once base_path("routes\\api\\auth.php");

    include_once base_path("routes\\api\\all_users.php");
    include_once base_path("routes\\api\\guest.php");

});
