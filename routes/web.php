<?php

use App\Http\Controllers\Backyard\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes([
    'register' => false,
    'verify' => false,
    'reset' => false,
    'confirm' => false
]);

// Route::get('/login', function(){
//     return "Ini login";
// })->name('login');

Route::get('/home', [App\Http\Controllers\Forecourt\HomeController::class, 'index'])->name('home');
Route::get('/register', ['uses' => 'App\Http\Controllers\Forecourt\User\RegisterController@showForm', 'as' => 'register']);
Route::post('/register', ['uses' => 'App\Http\Controllers\Forecourt\User\RegisterController@registerUser', 'as' => 'post.register']);
Route::get('/verification/{token}', ['uses' => 'App\Http\Controllers\Forecourt\User\VerificationController@verification', 'as' => 'verification']);
Route::get('/request/verification', ['uses' => 'App\Http\Controllers\Forecourt\User\VerificationController@requestVerification', 'as' => 'request.verification']);
Route::post('/request/verification', ['uses' => 'App\Http\Controllers\Forecourt\User\VerificationController@postRequestVerification', 'as' => 'post.request.verification']);
Route::get('/request/reset', ['uses' => 'App\Http\Controllers\Forecourt\User\ResetPasswordController@showRequestResetPasswordForm', 'as' => 'request.reset.password']);
Route::post('/request/reset', ['uses' => 'App\Http\Controllers\Forecourt\User\ResetPasswordController@postRequestResetPassword', 'as' => 'post.request.reset.password']);
Route::get('/reset-password/{token}', ['uses' => 'App\Http\Controllers\Forecourt\User\ResetPasswordController@showResetPasswordForm', 'as' => 'reset.password']);
Route::post('/reset-password', ['uses' => 'App\Http\Controllers\Forecourt\User\ResetPasswordController@postResetPassword', 'as' => 'post.reset.password']);

Route::group(['prefix' => 'backyard', 'as' => 'backyard.'], function(){
    // Home
    Route::get('home', ['uses'=> 'App\Http\Controllers\Backyard\HomeController@index', 'as' => 'home']);
    Route::group(['prefix' => 'user', 'as' => 'user.'], function(){
        Route::get('home', ['uses' => 'App\Http\Controllers\Backyard\User\HomeController@index','as'=>'home']);
        // Roles
        Route::get('roles/indexData', ['uses' => 'App\Http\Controllers\Backyard\User\RoleController@indexData', 'as' => 'role.index.data']);
        Route::resource('roles', 'App\Http\Controllers\Backyard\User\RoleController',['names' => 'role']);
        // Users
        Route::get('users/indexData', ['uses' => 'App\Http\Controllers\Backyard\User\UserController@indexData', 'as' => 'user.index.data']);
        Route::resource('users', 'App\Http\Controllers\Backyard\User\UserController',['names' => 'user']);
    });
});
