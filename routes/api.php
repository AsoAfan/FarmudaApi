<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\FavouriteController;
use App\Http\Controllers\HadisController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TellerController;
use App\Http\Controllers\UserController;
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

//Route::middleware('cors')->group(function () {
Route::middleware('json')->group(function () {
    Route::get('test1', function () {
        return ["test" => glob(__DIR__ . '/*/*.php'),

        ];
    })->name('test1'); // DEV


    // ADMIN
    Route::middleware(['auth:sanctum', 'admin'])->group(function () {

        Route::get('/a/test', function () {
//        dd(request()->route()->middleware());
            return \request()->user();
        }); // DEV

// User
        Route::get('/users', [UserController::class, 'index']); // returns all users

        Route::get('/warn/{user}', [UserController::class, 'warn']); // send warning notification to user => {user} -> id

        // TODO: ADD URL TO UPDATE USER ROLE - DONE
        Route::post('/user/role/update/{user}', [\App\Http\Controllers\AdminController::class, 'promoteRequest']);
        Route::put('/user/role/{user}', [UserController::class, 'updateRole']);



// Hadises


        Route::delete('/hadis/destroy-related/{hadis}', [HadisController::class, 'destroyRelated'])
            ->missing(fn() => response(['errors' => "Hadis not found"], 400)); // Delete  TODO: Admins


        Route::delete('/teller/destroy/{teller}', [TellerController::class, 'destroy'])
            ->missing(fn() => response(["errors" => ["Teller not found"]], 400)); // Delete TODO: Admins


        Route::delete('/category/destroy/{category}', [CategoryController::class, 'destroy'])
            ->missing(fn() => response()->json(["errors" => ["Category not found"]], 400)); // Delete TODO: Admins


        Route::delete('/book/destroy/{book}', [BookController::class, 'destroy'])
            ->missing(fn() => response()->json(["errors" => "book not found"], 400)); // delete TODO: Admins


        Route::delete('/chapter/destroy/{chapter}', [ChapterController::class, 'destroy'])
            ->missing(fn() => response()->json(["errors" => ["Chapter not found"]], 400)); // delete TODO: Admins

    });


    // ADMIN_EDITOR
    Route::middleware(['auth:sanctum', 'admin-editor'])->group(function () {
        Route::get('/ae/test', fn() => auth()->user());

// Hadis
        Route::post('/hadis/store', [HadisController::class, 'store']); // create(Add new hadis) TODO: ADMINS, EDITOR

        Route::get('/hadis/toggle-feature/{hadis}', [HadisController::class, 'toggleFeature'])
            ->missing(fn() => response()->json(["errors" => ["Hadis not found"]], 400)); // update toggle statues toFALSE if True and to TRUE if False


        Route::put('/hadis/featured/update', [HadisController::class, "updateFeaturedLength"]);

        Route::put('hadis/update/{hadis}', [HadisController::class, "update"])
            ->missing(fn() => response()->json(['errors' => ["Hadis not found"]], 400)); // update TODO:  Admins, EDITOR

        Route::delete('/hadis/destroy/{hadis}', [HadisController::class, 'destroy'])
            ->missing(fn() => response()->json(['errors' => ["Hadis not found"]], 400)); // Delete  TODO: Admins


// Teller
        Route::post('teller/store', [TellerController::class, 'store']); // Create(Add new teller) TODO: Admins, EDITOR

        Route::put('teller/update/{teller}', [TellerController::class, 'update'])
            ->missing(fn() => response()->json(["errors" => ["Teller not found"]], 400)); // Update TODO: Admins, EDITOR

// Category
        Route::post('category/store', [CategoryController::class, 'store']); // create(Add new category) TODO: Admins, EDITOR
        Route::put('category/update/{category}', [CategoryController::class, 'update'])
            ->missing(fn() => response()->json(["errors" => ["Category not found"]], 400)); // Update TODO: Admins, EDITOR


// Book
        Route::post('book/store', [\App\Http\Controllers\BookController::class, 'store']); // create TODO: Admins, EDITOR

        Route::put('book/update/{book}', [\App\Http\Controllers\BookController::class, 'update'])
            ->missing(fn() => response()->json(['errors' => ['Book not found']], 400)); // update TODO: Admins, EDITOR


// Chapter
        Route::post('/chapter/store', [\App\Http\Controllers\ChapterController::class, 'store']); // create(Add new chapter)  TODO: Admins, EDITOR

        Route::put('/chapter/update/{chapter}', [\App\Http\Controllers\ChapterController::class, 'update'])
            ->missing(fn() => response()->json(["errors" => ["Chapter not found"]], 400)); // update TODO: Admins, EDITOR
    });


    // AUTH
    Route::middleware(['auth:sanctum'])->group(function () {

        // Auth
        Route::post('auth/logout', [AuthController::class, 'logout']);


        // User
        Route::get('/user', [\App\Http\Controllers\UserController::class, 'current']);
        Route::post('/user/image/{user}', [UserController::class, 'update']);

        // Notifications
        Route::get('/user/notifications', [NotificationController::class, 'index']);
        Route::get('/user/unread-notifications', [NotificationController::class, 'unreadAll']);
        Route::get('/user/read-notifications', [NotificationController::class, 'readAll']);
        Route::get('/user/notifications/read', [NotificationController::class, 'getReadNotifications']);
        Route::get('/user/notifications/unread', [NotificationController::class, 'getUnreadNotifications']);

        // Question
        Route::post('question/store', [QuestionController::class, 'store']); // TODO: Auth
        Route::put('question/update/{question}', [QuestionController::class, 'update'])
            ->missing(fn() => response()->json(["errors" => "Question not found"], 404)); // TODO: Auth

        Route::delete('question/destroy/{question}', [QuestionController::class, 'destroy'])
            ->missing(fn() => response()->json(["errors" => "Question not found"], 404)); // TODO: Auth


// Hadis


        Route::get('/favourite', [FavouriteController::class, 'index']);

        Route::get('/favourite/{hadis}', [FavouriteController::class, 'store'])
            ->missing(fn() => response()->json(["errors" => "Page not found", "status" => 404], 404));


    });


    // GUEST
    Route::middleware(['guest:sanctum'])->group(function () {

        // Password reset
        Route::post('/forget-password',[\App\Http\Controllers\PasswordResetController::class,'sendLink']);


        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);

        // Resend otp code
        Route::post('resend', [AuthController::class, 'sendOtp']);

        // Verify email
        Route::post('verify-email/{user:otp_secret_slug}', [EmailVerificationController::class, 'checkOtp'])
            ->missing(fn() => response()->json(["errors" => "Link Expired", 'status' => 410], 404));


        Route::get('not-auth', function () {
            return response()->json(["errors" => 'You are not authorized'], 401);
        })->name('login');

    });


    // ALL_USERS
    Route::get('/question/show', [QuestionController::class, 'index'])->middleware('json'); // TODO: All Users

    Route::post('/hadis/show', [HadisController::class, 'index']); // read | ?page=num_of_page => 3 per page for now TODO: ALL_USERS
    Route::get('/hadis/show/{hadis}', [HadisController::class, 'show']); // read | UPDATE: Returns Single hadith with specified id | EDITED: NOT with limited number of characters ?chars=max_num_of_chars TODO: ALL_USERS
    Route::get('/hadis/featured', [HadisController::class, 'showFeatures']); // read |  featured Hadises with limited number of characters ?chars=max_num_of_chars TODO: ALL_USERS
    Route::get('/hadis/latest', [HadisController::class, 'latest']); // read | 2 latest Hadises TODO: ALL_USERS

    Route::get('/teller/show', [TellerController::class, 'show']); // Read TODO: All_USERS

    Route::get('/category/show', [CategoryController::class, 'index']); // read (returns all categories) TODO: ALL_USERS


    Route::get('/book/show', [BookController::class, 'index']); // read TODO: ALL_USERS


    Route::get('/chapter/show', [\App\Http\Controllers\ChapterController::class, 'index']); // read TODO: ALL_USERS


//    include_once __DIR__ . '/api/all_users.php';
//    include_once base_path("routes\\api\\admin_editor.php");
//
//    include_once base_path("routes\\api\\auth.php");
//
//    include_once base_path("routes\\api\\all_users.php");
//    include_once base_path("routes\\api\\guest.php");

});
//});