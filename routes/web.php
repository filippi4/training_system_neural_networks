<?php
/* Маршруты к страницам */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\CustomAuthController;
use App\Models\Lesson;

Route::get('/', function () {
    return view('home', ['data' => Lesson::all()]);
})->name('home');

Route::get('/testing', function () {
    return view('testing');
})->name('testing');

Route::get('/glossary', function () {
    return view('glossary');
})->name('glossary');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/lessons',
    [ LessonController::class, 'allData']
)->name('lessons');

Route::get('/lessons/{id}',
    [ LessonController::class, 'showLesson']
)->name('one-lesson');


Route::get('/login', 
    [ CustomAuthController::class, 'login']
)->name('login')->middleware('alreadyLoggedIn');

Route::post('/login-user', 
    [ CustomAuthController::class, 'loginUser']
)->name('login-user');

Route::get('/logout-user', 
    [ CustomAuthController::class, 'logout']
)->name('logout-user');

Route::get('/registration', 
    [ CustomAuthController::class, 'registration']
)->name('registration')->middleware('alreadyLoggedIn');

Route::post('/register-user', 
    [ CustomAuthController::class, 'registerUser']
)->name('register-user');

Route::get('/dashboard',
    [ CustomAuthController::class, 'dashboard']
)->name('dashboard')->middleware('isLoggedIn');

Route::get('/admin', function () {
    return view('admin');
})->name('admin');

Route::post('/admin/add-lesson',
    [ LessonController::class, 'addLesson']
)->name('add-lesson-form');