<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

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
    return view('home');
});

Route::get('/home','App\Http\Controllers\MainController@home');
Route::get('/login','App\Http\Controllers\MainController@login');
Route::post('/login_auth','App\Http\Controllers\MainController@login_auth');
Route::get('/logout','App\Http\Controllers\MainController@logout')->name('logout');

Route::get('/register','App\Http\Controllers\RegisterController@show')->name('register.show');
Route::post('/register','App\Http\Controllers\RegisterController@register')->name('register.perform');

Route::get('/index', function()
{
    return view('index');
});

Route::get('/profile', function()
{
    return view('profile');
});
Route::get('/email', function()
{
    return view('email');
});

Route::get('/updateinfo','App\Http\Controllers\MainController@edit_profile')->name('edit_profile');
Route::put('/updateinfo','App\Http\Controllers\MainController@update_profile')->name('update_profile');

Route::get('/change_password','App\Http\Controllers\MainController@change_password')->name('change_password');
Route::post('/update_password','App\Http\Controllers\MainController@update_password')->name('update_password');

Route::get('/forgot-password', 'App\Http\Controllers\ForgotPasswordController@getEmail');
Route::post('/forgot-password', 'App\Http\Controllers\ForgotPasswordController@postEmail');

Route::get('/{token}/reset-password', 'App\Http\Controllers\ResetPasswordController@getPassword');
Route::post('/reset-password', 'App\Http\Controllers\ResetPasswordController@updatePassword');

Route::group([
    'prefix' => 'admin', 
    'as' => 'admin.', 
    'namespace' => 'Admin', 
    'middleware' => ['auth', 'twofactor']
], function () {
    Route::resource('permissions', 'PermissionsController');
    Route::resource('roles', 'RolesController');
    Route::resource('users', 'UsersController');
});

Route::get('/verify/resend', 'App\Http\Controllers\TwoFactorController@resend')->name('verify.resend');
Route::resource('/verify', 'App\Http\Controllers\TwoFactorController')->only(['index', 'store']);

