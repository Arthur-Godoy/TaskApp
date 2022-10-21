<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\BoardController;
use App\Http\Controllers\SubTaskController;
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
Route::put('editTask/{id}', [TaskController::class,'editTask'])->name('editTask')->middleware('auth');
Route::delete('/deleteTask/{id}',[TaskController::class,'deleteTask'])->name('deleteTask')->middleware('auth');
Route::post('/taskNew',[TaskController::class,'newTask'])->name('taskNew')->middleware('auth');
Route::get('/dashboard', [TaskController::class, 'dashboard'])->name('dashboard')->middleware('auth');

Route::get('/board/{id}',[BoardController::class,'board'])->name('board')->middleware('auth');
Route::post('/boardNew',[BoardController::class,'newBoard'])->name('boardNew')->middleware('auth');
Route::put('editBoard/{id}', [BoardController::class,'editBoard'])->name('editBoard')->middleware('auth');
Route::delete('/deleteBoard/{id}',[BoardController::class,'deleteBoard'])->name('deleteBoard')->middleware('auth');

Route::post('/subtaskChange',[SubTaskController::class,'changeSubtasksStatus'])->name('changeSubtasksStatus')->middleware('auth');
Route::delete('/deleteSubtask/{id}',[SubTaskController::class,'deleteSubtask'])->name('deleteSubtask')->middleware('auth');
