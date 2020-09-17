<?php

use App\Http\Controllers\HomeController;
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

Route::get('/Home', [HomeController::class, 'index']);

Route::get('/Home/login', [HomeController::class, 'login']);

Route::post('Home/post_login', [HomeController::class, 'post_login']);

Route::get('Home/signup', [HomeController::class, 'signup']);

Route::post('Home/post_signup', [HomeController::class, 'post_signup']);
//Route::resource('Home', 'HomeController');