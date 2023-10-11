<?php

use App\Http\Controllers\PostController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', function (Request $request) {
    $user = new User;
    $user->email = $request->email;
    $user->password = $request->password;
    $user->save();
    if ($user) {
        return response()->json(['status' => true, 'user' => $user]);
    } else {
        return response()->json(['status' => false]);
    }
});
Route::middleware('auth:api')->apiResource('posts', PostController::class);
Route::middleware('auth:api')->get('public/posts', [PostController::class, 'public']);
