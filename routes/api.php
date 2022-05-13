<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/tokens/create', function (Request $request) {
    $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required','confirmed'],
        'name' => ['required','string'],
        'token_name' => ['required','string'],
    ]);

    /*
    ** scenarios
    validate data,
    if not exist >> create it and give token
    if exist with wrong credentials >> error
    if exist >> give new token ,, so I didn't used unique:users validation
    */

    $user = User::where('email',  $request->email)->first();

    if ( $user && ! Hash::check($request->password, $user->password)) {
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.']
        ]);
    }
    if (! $user) {
        $user = User::create(array_merge($request->all(),['password'=>Hash::make($request->password)]));
    }
    $token = $user->createToken($request->token_name);

    return ['token' => $token->plainTextToken];
});

Route::middleware('auth:sanctum')->group( function () {
    Route::get('posts',[PostController::class, 'index'])->name('posts.index');
    Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::post('posts/store', [PostController::class, 'store'])->name('posts.store');
    }
);


