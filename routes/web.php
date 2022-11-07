<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;

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
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function (){
    $users=DB::table('users')->get();
    return view('dashboard' ,compact('users'));
})->name('dashboard');

Route::middleware(['auth:sanctum', 'verified'])->group(function(){
    // department
    Route::get('/department/all',[DepartmentController::class,'index'])->name('department');
    Route::post('/department/add',[DepartmentController::class,'store'])->name('addDepartment');
    Route::get('/department/edit/{id}',[DepartmentController::class,'edit']);
    Route::post('/department/update/{id}',[DepartmentController::class,'update']);
    
    // back button
    Route::get('/department/back',[DepartmentController::class,'back']);
    Route::get('/student/back',[StudentController::class,'back']);
    // softdelete
    Route::get('/department/softdelete/{id}',[DepartmentController::class,'softdelete']);
    //restore
    Route::get('/department/restore/{id}',[DepartmentController::class,'restore']);
    // forcedelete
    Route::get('/department/delete/{id}',[DepartmentController::class,'delete']);

    // student
    Route::get('/student/all',[StudentController::class,'index'])->name('student');
    Route::post('/student/add',[StudentController::class,'store'])->name('addStudent');

    // student delete
    Route::get('/student/delete/{id}',[StudentController::class,'delete']);

    // teacher
    Route::get('/teacher/all',[TeacherController::class,'index'])->name('teacher');
    Route::post('/teacher/add',[TeacherController::class,'store'])->name('addTeacher');

    // teacher delete
    Route::get('/teacher/delete/{id}',[TeacherController::class,'delete']);
});