<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\TodoController;

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

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');
Route::post('/home/create/todo', [TodoController::class, 'create'])->name('to_do.create_to_do');
Route::get('/home/remove/todo/{id}', [TodoController::class, 'remove'])->name('to_do.remove_to_do');
Route::get('/home/show/todo/{id}', [TodoController::class, 'show_to_be_updated'])->name('to_do.show_to_do');
Route::post('/home/update/todo', [TodoController::class, 'update'])->name('to_do.update_to_do');