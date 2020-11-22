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

// Auth
Auth::routes();

// Home
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Profile
Route::get('/profile/{user_id}', [App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/{user_id}/edit', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
Route::patch('/profile/{user_id}', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');

// ToDo
Route::get("/todo", [App\Http\Controllers\ToDoController::class, 'index'])->name('todo');
Route::post("/todo/addTask", [\App\Http\Controllers\ToDoController::class, 'addTask'])->name('addTask');
Route::post("/todo/completeTask", [\App\Http\Controllers\ToDoController::class, 'completeTask'])->name('completeTask');
Route::post("/todo/updateBody", [\App\Http\Controllers\ToDoController::class, 'updateBody'])->name('todo.updateBody');
Route::post("/todo/updateDate", [\App\Http\Controllers\ToDoController::class, 'updateDate'])->name('todo.updateDate');

// Contact
Route::post("/contact/addContact", [\App\Http\Controllers\ContactController::class, 'addContact'])->name('contact.addContact');
Route::post("/contact/removeContact", [\App\Http\Controllers\ContactController::class, 'removeContact'])->name('contact.removeContact');
Route::post("/contact/search", [\App\Http\Controllers\ContactController::class, 'search'])->name('contact.search');
Route::get("/contact/{user_id}/email", [App\Http\Controllers\ContactController::class, 'email'])->name('contact.email');
Route::post("/contact/{user_id}/email/send", [App\Http\Controllers\ContactController::class, 'send_email'])->name('contact.send_email');

// professor rate
Route::get('/profRate', [App\Http\Controllers\ProfRateController::class,'search'])->name('profSearch');
Route::get('/profRate/rate/{prof_id}', [App\Http\Controllers\ProfRateController::class, 'rate'])->name('profRate');
Route::get('/profRate/rate/{prof_id}/create', [App\Http\Controllers\RatingController::class, 'create']);
//Route::post('/search/rate/{prof_id}', [App\Http\Controllers\ProfRateController::class, 'rate'])->name('profRate.update');

// Posts
Route::post('', [App\Http\Controllers\PostController::class, 'store'])->name('post.store');
Route::delete('', [App\Http\Controllers\PostController::class, 'destroy'])->name('post.destroy');
// Listings
Route::get("/listings", [App\Http\Controllers\ListingController::class, 'index'])->name('listing.index');
Route::get("/listings/create", [App\Http\Controllers\ListingController::class, 'create'])->name('listing.create');
Route::post("/listings/create/new", [App\Http\Controllers\ListingController::class, 'create_post'])->name('listing.create_post');
