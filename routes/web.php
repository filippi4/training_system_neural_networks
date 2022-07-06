<?php
/* Маршруты к страницам */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\GlossaryController;
use App\Models\Lesson;

Route::get('/',
    [HomeController::class, 'pageHome']
)->name('home');

Route::get('/testing',
    [ TestController::class, 'pageTesting']
)->name('testing');

Route::get('/testing/test/{test}', 
    [ TestController::class, 'pageTest']
)->name('test');

Route::post('/testing/test/{test}/check',
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

Route::get('/admin/edit-lesson/add', 
    [ LessonController::class, 'pageAddLesson']
)->name('add-lesson')->middleware('is_admin');

Route::post('/admin/edit-lesson/add-lesson',
    [ LessonController::class, 'addLesson']
)->name('add-lesson-form')->middleware('is_admin');

Route::get('/admin/edit-lessons/change/{id}', 
    [ LessonController::class, 'changeLesson']
)->name('change-lesson')->middleware('is_admin');

Route::post('/admin/edit-lessons/change/{id}/save', 
    [ LessonController::class, 'saveChangeLesson']
)->name('save-change-lesson-form')->middleware('is_admin');

Route::get('/admin/edit-lessons/delete-lesson/{id}',
    [ LessonController::class, 'deleteLesson']
)->name('delete-lesson-form')->middleware('is_admin');

Route::get('/admin/edit-tests',
    [ TestController::class, 'pageEditTests']
)->name('edit-tests')->middleware('is_admin');

Route::get('/admin/edit-tests/add',
    [ TestController::class, 'pageAddTest']
)->name('add-test')->middleware('is_admin');

Route::post('/admin/edit-tests/add',
    [ TestController::class, 'addTest']
)->name('add-test-form')->middleware('is_admin');

Route::get('/admin/edit-tests/delete/{test}',
    [ TestController::class, 'deleteTest']
)->name('delete-test-form')->middleware('is_admin');

Route::get('/admin/edit-tests/change/{test}', 
    [ TestController::class, 'pageEditTest']
)->name('change-test')->middleware('is_admin');

Route::get('/admin/edit-test/questions/add',
    [ TestController::class, 'pageAddQuestion']
)->name('add-question')->middleware('is_admin');

Route::post('/admin/edit-test/questions/add',
    [ TestController::class, 'addQuestion']
)->name('add-question-form')->middleware('is_admin');

Route::get('/admin/edit-test/change/{question}', 
    [ TestController::class, 'pageChangeQuestion']
)->name('change-question')->middleware('is_admin');

Route::post('/admin/edit-test/change/{id}/save', 
    [ TestController::class, 'saveChangeQuestion']
)->name('save-change-question-form')->middleware('is_admin');

Route::get('/admin/edit-test/delete-question/{id}',
    [ TestController::class, 'deleteQuestion']
)->name('delete-edit-test-form')->middleware('is_admin');

Route::post('/admin/change-test-form',
    [ TestController::class, 'changeTest']
)->name('change-test-form')->middleware('is_admin');