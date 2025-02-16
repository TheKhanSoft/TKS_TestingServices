<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\FacultyMemberController;
use App\Http\Controllers\QuestionTypeController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionOptionController;
use App\Http\Controllers\PaperCategoryController;
use App\Http\Controllers\UserCategoryController;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TestAttemptController;
use App\Http\Controllers\AnswerController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

Route::resource('departments', DepartmentController::class);
Route::resource('subjects', SubjectController::class);
Route::resource('faculty-members', FacultyMemberController::class);
Route::resource('question-types', QuestionTypeController::class);
Route::resource('questions', QuestionController::class);
Route::resource('question-options', QuestionOptionController::class);
Route::resource('paper-categories', PaperCategoryController::class);
Route::resource('user-categories', UserCategoryController::class);
Route::resource('papers', PaperController::class);
Route::resource('users', UserController::class);
Route::resource('test-attempts', TestAttemptController::class);
Route::resource('answers', AnswerController::class);

Route::get('/departments/search', [DepartmentController::class, 'search'])->name('departments.search');
Route::get('/subjects/search', [SubjectController::class, 'search'])->name('subjects.search');
Route::get('/faculty-members/search', [FacultyMemberController::class, 'search'])->name('faculty-members.search');
Route::get('/question-types/search', [QuestionTypeController::class, 'search'])->name('question-types.search');
Route::get('/papers/search', [PaperController::class, 'search'])->name('papers.search');
Route::get('/user-categories/search', [UserCategoryController::class, 'search'])->name('user-categories.search');
Route::get('/users/search', [UserController::class, 'search'])->name('users.search');
