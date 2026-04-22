<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsersAttendanceController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminsAttendanceController;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use Laravel\Fortify\RoutePath;

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

Route::middleware('auth')->group(function(){
    Route::get('/attendance',[UsersAttendanceController::class,'create']);
    Route::post('/attendance',[UsersAttendanceController::class,'startWork']);
    Route::get('/attendance/at_work',[UsersAttendanceController::class,'atWork']);
    Route::patch('/attendance',[UsersAttendanceController::class,'update']);
    Route::get('/attendance/break_time',[UsersAttendanceController::class,'breakTime']);
    Route::patch('/attendance/finish_break',[UsersAttendanceController::class,'finishBreak']);
    Route::get('/attendance/finish_work',[UsersAttendanceController::class,'finishWork']);

    Route::get('/attendance/list',[UsersAttendanceController::class,'index']);
    Route::get('/attendance/detail/{id}',[UsersAttendanceController::class,'edit']);
    Route::post('/attendance/detail/{id}',[UsersAttendanceController::class,'detail']);
    Route::get('/stamp_correction_request/list',[UsersAttendanceController::class,'show']);
});

Route::prefix('admin')->group(function(){
    Route::get('/login',[AdminController::class,'create']);
    Route::post('/login',[AdminController::class,'login']);
});

Route::middleware('auth:admin')->group(function(){
    Route::prefix('admin')->group(function () {
        Route::get('/attendance/list',[AdminsAttendanceController::class,'index'])->name('attendance.index');
        Route::get('/attendance/{id}',[AdminsAttendanceController::class,'detail']);
        Route::patch('/attendance/{id}',[AdminsAttendanceController::class,'update']);
        Route::post('/logout', [AdminController::class, 'destroy']);
        Route::get('/staff/list',[AdminsAttendanceController::class,'staffList']);
        Route::get('/attendance/staff/{id}',[AdminsAttendanceController::class,'staffAttendance']);
    });
    Route::get('/stamp_correction_request/list',[AdminsAttendanceController::class,'show']);
    Route::get('/stamp_correction_request/list/{status}',[AdminsAttendanceController::class,'show']);
    Route::get('/stamp_correction_request/approve/{id}',[AdminsAttendanceController::class,'edit']);
    Route::patch('/stamp_correction_request/approve/{id}',[AdminsAttendanceController::class,'approve']);
});

