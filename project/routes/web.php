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

// // Messages
// Route::get('/chat', [\App\Http\Controllers\ChatsController::class, 'index']);
// Route::get('messages', [\App\Http\Controllers\ChatsController::class, 'fetchMessages']);
// Route::post('messages', [\App\Http\Controllers\ChatsController::class, 'sendMessage']);
// professor rate
Route::get('/profRate', [App\Http\Controllers\ProfRateController::class,'search'])->name('profSearch');
//Route::get('/profRate/{prof_id}/rate', [App\Http\Controllers\ProfRateController::class, 'rate'])->name('profRate');
//Route::patch('/search/{prof_id}/rate', [App\Http\Controllers\ProfRateController::class, 'rate'])->name('profRate.update');

// Posts
Route::post('', [App\Http\Controllers\PostController::class, 'store'])->name('post.store');
Route::delete('', [App\Http\Controllers\PostController::class, 'destroy'])->name('post.destroy');
