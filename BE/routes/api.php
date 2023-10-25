<?php

use App\Models\User;
use App\Library\SendSMS;
use App\Mail\OrderShipped;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;

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
Route::middleware('auth:api')->apiResource('likes', LikeController::class);
Route::middleware('auth:api')->post('likes/{postID}', [LikeController::class,'setLike']);
Route::post(
    'verify',
    function (Request $request) {
        $code = rand(1111,9999);
        SendSMS::sendVerification($request->username, $code);
        $user = User::where('mobile', $request->username)->first();
        $user->password = $code;
        $user->save();
        return 1;
    }
);
Route::get('test-mail',
 function () {
    Mail::to(User::find(13))->send(new OrderShipped());
 });
