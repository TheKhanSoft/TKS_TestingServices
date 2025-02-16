<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Route::apiResource('departments', Api\DepartmentController::class);
// Route::apiResource('subjects', Api\SubjectController::class);
// Route::apiResource('faculty-members', Api\FacultyMemberController::class);
// Route::apiResource('question-types', Api\QuestionTypeController::class);
// Route::apiResource('questions', Api\QuestionController::class);
// Route::apiResource('question-options', Api\QuestionOptionController::class);
// Route::apiResource('paper-categories', Api\PaperCategoryController::class);
// Route::apiResource('user-categories', Api\UserCategoryController::class);
// Route::apiResource('papers', Api\PaperController::class);
// Route::apiResource('users', Api\UserController::class);
// Route::apiResource('test-attempts', Api\TestAttemptController::class);
// Route::apiResource('answers', Api\AnswerController::class);

// Route::get('/departments/search', [Api\DepartmentController::class, 'search'])->name('api.departments.search');
// Route::get('/subjects/search', [Api\SubjectController::class, 'search'])->name('api.subjects.search');
// Route::get('/faculty-members/search', [Api\FacultyMemberController::class, 'search'])->name('api.faculty-members.search');
// Route::get('/question-types/search', [Api\QuestionTypeController::class, 'search'])->name('api.question-types.search');
// Route::get('/papers/search', [Api\PaperController::class, 'search'])->name('api.papers.search');
// Route::get('/user-categories/search', [Api\UserCategoryController::class, 'search'])->name('api.user-categories.search');
// Route::get('/users/search', [Api\UserController::class, 'search'])->name('api.users.search');