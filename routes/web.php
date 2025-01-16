<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//********************************* */ admin routes **********************************
Route::get('admin-register', [AdminController::class, 'create'])
    ->name('admin-register');
Route::post('admin-register', [AdminController::class, 'store']);
Route::get('admin-login', function () {
    return view('auth.admin-login');
})
    ->name('admin-login');
Route::post('admin-login', [AdminController::class, 'login']);

Route::middleware('auth:admin')->group(function () {
    // dd('route');
    Route::get('/admin-dashboard', function () {
        return view('admin-dashboard');
    })->name('admin-dashboard');
    Route::post('admin-logout', [AdminController::class, 'destroy'])
        ->name('admin-logout');
});

//************************************** */ student routes  ******************************************
Route::get('student-register', [StudentController::class, 'create'])
    ->name('student-register');
Route::post('student-register', [StudentController::class, 'store']);
Route::get('student-login', function () {
    return view('auth.student-login');
})->name('student-login');
Route::post('student-login', [StudentController::class, 'login']);

Route::middleware('auth:student')->group(function () {
    Route::get('/student-dashboard', function () {
        return view('admin-dashboard');
    })->name('student-dashboard');
    Route::post('student-logout', [StudentController::class, 'destroy'])
        ->name('student-logout');
});


//****************************************Teacher Routes *********************************************** */

Route::get('teacher-register',function(){
    return view('auth.teacher-register');
});
Route::post('teacher-register',[TeacherController::class,'create'])->name('teacher-register');

Route::get('teacher-login',function(){
    return view('auth.teacher-login');
});
Route::post('teacher-login',[TeacherController::class,'teacherlogin'])->name('teacher-login');

Route::get('teacher-dashboard',function(){
    // dd("rr");
return view('admin-dashboard');
});
Route::post('teacher-logout',[TeacherController::class,'teacherlogout'])->name('teacher-logout');


require __DIR__ . '/auth.php';
