<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\PaymentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::post('register', 'UserController@register');
Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'authenticate']);
Route::get('open', [DataController::class,'open'])->middleware('throttle:3');
Route::post('pay', [PaymentController::class,'store'])->middleware('throttle:3');

Route::group(['middleware' => ['jwt.verify','throttle:1,1']], function() {
    Route::get('user', [UserController::class,'getAuthenticatedUser']);
    Route::get('closed', [DataController::class,'closed']);
});

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
