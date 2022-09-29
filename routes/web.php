<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

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

Route::get('/',[TaskController::class,'index']);
Route::get('/dashboard', [TaskController::class,'dashboard'])->middleware('auth');
Route::get('/board/{id}',[TaskController::class,'board'])->name('board')->middleware('auth');
Route::post('/boardNew',[TaskController::class,'newBoard'])->name('boardNew')->middleware('auth');
Route::post('/taskNew',[TaskController::class,'newTask'])->name('taskNew')->middleware('auth');
