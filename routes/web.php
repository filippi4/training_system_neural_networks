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

Route::get('/testing/test/{question_type}', 
    [ TestController::class, 'showTest']
)->name('test');

/**
 * BAD: question_type передается от страницы к странице
 * TODO: переписать с отдельной таблицей вопросов
 * с типом вопроса, тест ссылается на вопрос по id 
 */ 
Route::post('/testing/test/check/{question_type}',
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

// Route::get('/admin/dashboard', function () {
//     return view('admin-dashboard');
// })->name('admin-dashboard')->middleware('is_admin');

Route::get('/admin/edit-lessons',
    [ LessonController::class, 'editLessons']
)->name('edit-lessons')->middleware('is_admin');

Route::get('/admin/edit-lesson/add', function () {
    return view('lessons.add-lesson');
})->name('add-lesson')->middleware('is_admin');

Route::post('/admin/edit-test/add-lesson',
    [ LessonController::class, 'addLesson']
)->name('add-lesson-form')->middleware('is_admin');

Route::get('/admin/edit-lessons/change/{id}', 
    [ LessonController::class, 'changeLesson']
)->name('change-lesson')->middleware('is_admin');

Route::post('/admin/edit-lessons/change/{id}/save', 
    [ LessonController::class, 'saveChangeLesson']
)->name('save-change-lesson-form')->middleware('is_admin');

Route::get('/admin/edit-lessons/remove-lesson/{id}',
    [ LessonController::class, 'removeLesson']
)->name('remove-lesson-form')->middleware('is_admin');

Route::get('/admin/edit-test',
    [ TestController::class, 'editTest']
)->name('edit-test')->middleware('is_admin');

Route::get('/admin/edit-test/add', function () {
    return view('tests.add-question');
})->name('add-edit-test')->middleware('is_admin');

Route::post('/admin/edit-test/add-question',
    [ TestController::class, 'addQuestion']
)->name('add-edit-test-form')->middleware('is_admin');

Route::get('/admin/edit-test/change/{id}', 
    [ TestController::class, 'changeQuestion']
)->name('change-question')->middleware('is_admin');

Route::post('/admin/edit-test/change/{id}/save', 
    [ TestController::class, 'saveChangeQuestion']
)->name('save-change-question-form')->middleware('is_admin');

Route::get('/admin/edit-test/remove-question/{id}',
    [ TestController::class, 'removeQuestion']
)->name('remove-edit-test-form')->middleware('is_admin');

Route::post('/admin/change-test-form',
    [ TestController::class, 'changeTest']
)->name('change-test-form')->middleware('is_admin');