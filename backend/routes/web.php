<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\FolderController;
use App\Http\Controllers\HomeController;

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

// 認証機能のルート
Auth::routes();

// Home画面のルート
Route::get('/', [HomeController::class, 'index'])->name('home');

// タスクのルート
Route::get('/folders/{id}/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::get('/folders/{id}/tasks/create', [TaskController::class, 'showCreateForm'])->name('tasks.create');
Route::post('/folders/{id}/tasks/create' ,[TaskController::class, 'create']);

// タスク編集のルート
Route::get('/folders/{id}/tasks/{task_id}/edit', [TaskController::class, 'showEditForm'])->name('tasks.edit');
Route::post('/folders/{id}/tasks/{task_id}/edit', [TaskController::class, 'edit']);

// フォルダのルート
Route::get('/folders/create', [FolderController::class, 'showCreateForm'])->name('folders.create');
Route::post('/folders/create', [FolderController::class, 'create']);


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
