<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthViewController;
use App\Http\Controllers\ControllerAPI;

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


//RUTAS LOGIN
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [ControllerAPI::class, 'login'])->name('login.post');

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [ControllerAPI::class, 'register'])->name('register.post');

Route::get('/reset-password', function () {
    return view('auth.reset-password');
})->name('reset-password');

Route::post('/reset-password', [ControllerAPI::class, 'resetPassword'])->name('reset-password.post');

//RUTA PAGINA PRINCIPAL
Route::get('/home', function () {
    return response('Hola');
})->middleware('auth')->name('home');

// CRUD de usuarios
Route::get('/users', [ControllerAPI::class, 'index'])->name('users.index');
Route::get('/users/create', [ControllerAPI::class, 'create'])->name('users.create');
Route::post('/users', [ControllerAPI::class, 'store'])->name('users.store');
Route::get('/users/{id}/edit', [ControllerAPI::class, 'edit'])->name('users.edit');
Route::put('/users/{id}', [ControllerAPI::class, 'update'])->name('users.update');
Route::delete('/users/{id}', [ControllerAPI::class, 'destroy'])->name('users.destroy');



