<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\App;
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
    // will only show welcome page for unauthorized users
    // otherwise go to home page
    if (Auth::guest())
    {
        return view('welcome');
    }
    else
    {
        return redirect(route('home.index'));
    }
});


Route::get('/Home', [HomeController::class, 'index'])->name('home.index');

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

// Classes
Route::get("/Classes", [\App\Http\Controllers\ClassController::class, 'index'])->name('class.index');
Route::get("/Classes/{id}", [App\Http\Controllers\ClassController::class, 'show'])->name('class.show');
Route::get("/ClassSearch", [App\Http\Controllers\ClassController::class, 'search'])->name('class.search');
Route::post("/ClassSearch/searching", [App\Http\Controllers\ClassController::class, 'search_post'])->name('class.search_post');
Route::post("/Class/Create", [App\Http\Controllers\ClassController::class, 'addClass'])->name('class.add');
Route::get("/Class/Join/{class_id}", [\App\Http\Controllers\ClassController::class, 'joinClass'])->name('class.join');
Route::get("/Class/Leave/{class_id}", [\App\Http\Controllers\ClassController::class, 'leaveClass'])->name('class.leave');
Route::get("/Class/Members/{class_id}", [\App\Http\Controllers\ClassController::class, 'showMembers'])->name('class.members');
Route::get("/Class/All", [\App\Http\Controllers\ClassController::class, 'allClasses'])->name('class.all');

// Contact
Route::post("/contact/addContact", [\App\Http\Controllers\ContactController::class, 'addContact'])->name('contact.addContact');
Route::post("/contact/removeContact", [\App\Http\Controllers\ContactController::class, 'removeContact'])->name('contact.removeContact');
Route::post("/contact/search", [\App\Http\Controllers\ContactController::class, 'search'])->name('contact.search');
Route::get("/contact/{user_id}/email", [App\Http\Controllers\ContactController::class, 'email'])->name('contact.email');
Route::post("/contact/{user_id}/email/send", [App\Http\Controllers\ContactController::class, 'send_email'])->name('contact.send_email');

// professor search and add
Route::get('/profRate', [App\Http\Controllers\ProfRateController::class,'search'])->name('profSearch.search');
Route::get('/profRate/create', [App\Http\Controllers\ProfRateController::class,'create'])->name('profSearch.create');
Route::post('/profRate/store', [App\Http\Controllers\ProfRateController::class,'store'])->name('profSearch.store');
Route::post("/profRate/search", [\App\Http\Controllers\ProfRateController::class, 'search2'])->name('profSearch.search2');

//rating a professor
Route::get('/profRate/rate/{prof_id}', [App\Http\Controllers\ProfRateController::class,'rate'])->name('profRate.show');
Route::post('/profRate/rate/store', [App\Http\Controllers\RatingController::class, 'store'])->name('Ratings.store');

// Posts
Route::post('', [App\Http\Controllers\PostController::class, 'store'])->name('post.store');
Route::delete('/delete', [App\Http\Controllers\PostController::class, 'destroy'])->name('post.destroy');
Route::post('/edit', [App\Http\Controllers\PostController::class, 'editPost'])->name('post.edit');

// Listings
Route::get("/listings", [App\Http\Controllers\ListingController::class, 'index'])->name('listing.index');
Route::get("/listings/create", [App\Http\Controllers\ListingController::class, 'create'])->name('listing.create');
Route::post("/listings/create/new", [App\Http\Controllers\ListingController::class, 'create_post'])->name('listing.create_post');
Route::get("/listings/{user_id}", [App\Http\Controllers\ListingController::class, 'show'])->name('listing.show');
Route::get("/listings/details/{listing_id}", [App\Http\Controllers\ListingController::class, 'details'])->name('listing.details');

// these probably should be posted for security reasons, for now just checking user auth
Route::get("/listing/delete/{id}", [App\Http\Controllers\ListingController::class, 'delete'])->name("listing.delete");
Route::get("/listing/sold/{id}", [App\Http\Controllers\ListingController::class, 'sold'])->name("listing.sold");

// Mail
Route::get("/inbox", [\App\Http\Controllers\MailController::class, 'index'])->name('mail.index');
Route::get("/send/{to_id}/{listing_id}", [\App\Http\Controllers\MailController::class, 'send'])->name('mail.send');
Route::post("/send/sending", [\App\Http\Controllers\MailController::class, 'send_post'])->name('mail.send_post');
Route::get("/show/{mail_id}", [\App\Http\Controllers\MailController::class, 'show'])->name('mail.show');
Route::post("/mail/delete", [\App\Http\Controllers\MailController::class, 'delete'])->name('mail.delete');

//comments
Route::post('/comment', [App\Http\Controllers\CommentsController::class, 'store'])->name('comments.store');
Route::delete('/comment/delete', [App\Http\Controllers\CommentsController::class, 'destroy'])->name('comment.destroy');

// Important Dates
Route::post('/event/add', [\App\Http\Controllers\ImportantDateController::class, 'add'])->name('event.add');
Route::get('/event/{id}', [\App\Http\Controllers\ImportantDateController::class, 'show'])->name('event.show');

