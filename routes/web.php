<?php
/* Маршруты к страницам */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\GlossaryController;
use App\Models\Lesson;

Route::get('/', function () {
    return view('home', ['data' => Lesson::all()]);
})->name('home');

Route::get('/testing', function () {
    return view('testing');
})->name('testing');

Route::get('/testing/test', 
    [ TestController::class, 'showTest']
)->name('test');

Route::post('/testing/test/check',
    [TestController::class, 'checkTest']
)->name('check-test-form');

Route::get('/glossary', function () {
    return view('glossary');
})->name('glossary');

Route::get('/glossary/{word}', 
    [ GlossaryController::class, 'showDefinition']
)->name('definition-glossary');

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

Route::get('/logout', 
    [ CustomAuthController::class, 'logout']
)->name('logout')->middleware('isLoggedIn');;

Route::get('/registration', 
    [ CustomAuthController::class, 'registration']
)->name('registration')->middleware('alreadyLoggedIn');

Route::post('/register-user', 
    [ CustomAuthController::class, 'registerUser']
)->name('register-user');

Route::get('/dashboard',
    [ CustomAuthController::class, 'dashboard']
)->name('dashboard')->middleware('isLoggedIn');

Route::get('/dashboard/test-results', 
    [ TestController::class, 'showUserTestResults']
)->name('user-test-results')->middleware('isLoggedIn');

Route::get('/admin/dashboard', function () {
    return view('admin-dashboard');
})->name('admin-dashboard')->middleware('is_admin');

Route::post('/admin/add-lesson',
    [ LessonController::class, 'addLesson']
)->name('add-lesson-form')->middleware('is_admin');

Route::get('/admin/edit-test',
    [ TestController::class, 'editTest']
)->name('edit-test')->middleware('is_admin');

Route::post('/admin/change-test-form',
    [ TestController::class, 'changeTest']
)->name('change-test-form')->middleware('is_admin');