<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopicsController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\JoinClassroomController;
use Illuminate\Support\Facades\Route;

// الصفحة الرئيسية
Route::get('/', function () {
    return view('welcome');
});

// مسار home لتوجيه المستخدم بعد تسجيل الدخول
Route::get('/home', function () {
    return redirect()->route('dashboard');
})->name('home');

// مسار dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// مجموعة المسارات المحمية بالمصادقة
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::get('/ ', [ClassroomController::class, 'trashed'])
        ->name('classrooms.trashed');
    Route::put('/classrooms/trashed/{classroom}', [ClassroomController::class, 'restore'])
        ->name('classrooms.restore');
    Route::delete('/classrooms/trashed/{classroom}', [ClassroomController::class, 'forDelete'])
        ->name('classrooms.forDelete');
        Route::resource('classrooms', ClassroomController::class)->names('classrooms');
        Route::resource('topics', TopicsController::class)->names('topics');
    
    Route::get('/classrooms/{classroom}/join', [JoinClassroomController::class, 'create'])
      ->middleware('signed')
      ->name('classrooms.join');
    Route::post('/classrooms/{classroom}/join', [JoinClassroomController::class, 'store']);
});

// تضمين مسارات المصادقة
require __DIR__ . '/auth.php';
