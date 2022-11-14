<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Elastic\Elasticsearch;
use Elastic\Elasticsearch\ClientBuilder;


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

// Route::get('/', function () {   
//     require '/Users/sanjanabolla/example-app/vendor/autoload.php';
//     $client = ClientBuilder::create()->build();
//     var_dump($client);
// });

Route::get('/', function () {
    return view('home');
});

Route::get('/home','App\Http\Controllers\MainController@home')->name('home');
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

Route::get('/twofactor', function()
{
    return view('twofactor');
});

Route::get('/updateinfo','App\Http\Controllers\MainController@edit_profile')->name('edit_profile');
Route::put('/updateinfo','App\Http\Controllers\MainController@update_profile')->name('update_profile');

Route::get('/uploadetd','App\Http\Controllers\MainController@uploadetd')->name('upload_etd');
Route::post('/uploadetd_success','App\Http\Controllers\MainController@uploadetd_success')->name('uploadetd_success');


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

Route::get('/searching', 'App\Http\Controllers\ElasticsearchController@es')->name('search');
//Route::get('/counting', 'App\Http\Controllers\ElasticsearchController@counter')->name('counter');

Route::get('/search_login', 'App\Http\Controllers\ElasticsearchController@es')->name('lsearch');

Route::get('/search', function () {
    return view('search');
});

Route::get('/dissertation_view/{id}', 'App\Http\Controllers\ElasticsearchController@dissertation_details')->name('paper');
Route::get('/pdf_view/{pdfid}', 'App\Http\Controllers\ElasticsearchController@pdf');

// Route::get('/dissertation_view', function () {
//     return view('dissertation');
// });
