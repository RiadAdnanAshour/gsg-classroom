<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TopicsController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\ClassworkController;
use App\Http\Controllers\ClassroomPeopleController;
use App\Http\Controllers\CommentController;
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

    // Route::resource([
    //     'classrooms'=> ClassroomController::class,
    //     'topics'=> TopicsController::class,
    //     'classrooms.classwork'=> ClassworkController::class,
    // ]);
    Route::resource('classrooms', ClassroomController::class);
    Route::resource('topics', TopicsController::class);
    Route::resource('classrooms.classwork', ClassworkController::class);



    Route::get('/classrooms/{classroom}/join', [JoinClassroomController::class, 'create'])
        ->middleware('signed')
        ->name('classrooms.join');
    Route::post('/classrooms/{classroom}/join', [JoinClassroomController::class, 'store']);
    Route::get('/classrooms/{classroom}/people',[ClassroomPeopleController::class, 'index'])
    ->name('classrooms.people');
    Route::delete('/classrooms/{classroom}/people',[ClassroomPeopleController::class, 'destroy'])
    ->name('classrooms.people.destroy');
    

    Route::post('comments.store', [CommentController::class, 'store'])->name('comments.store');
    

});

// تضمين مسارات المصادقة
require __DIR__ . '/auth.php';
