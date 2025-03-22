<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthViewController;
use App\Http\Controllers\ControllerAPI;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\AdminMiddleware;

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

Route::get('/home', function() {
    return view('home');
})->middleware('auth');

// Rutas públicas
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/reset-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('reset.post');

// Rutas protegidas por autenticación
Route::middleware([AuthMiddleware::class])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
   
    Route::middleware(['admin'])->group(function () {
    // CRUD de usuarios
    Route::get('/users', [ControllerAPI::class, 'index'])->name('users.index');
    Route::get('/users/create', [ControllerAPI::class, 'create'])->name('users.create');
    Route::post('/users', [ControllerAPI::class, 'store'])->name('users.store');
    Route::get('/users/{id}/edit', [ControllerAPI::class, 'edit'])->name('users.edit');
    Route::put('/users/{id}', [ControllerAPI::class, 'update'])->name('users.update');
    Route::delete('/users/{id}', [ControllerAPI::class, 'destroy'])->name('users.destroy');
    Route::get('/users/pdf', [ControllerAPI::class, 'exportPdf'])->name('users.exportPdf');
    Route::get('/users/excel', [ControllerAPI::class, 'exportExcel'])->name('users.exportExcel');
    Route::get('/users/grafica', [ControllerAPI::class, 'showGraph'])->name('users.grafica');
    Route::post('/users/importar', [ControllerAPI::class, 'importExcel'])->name('users.importExcel');

    // CRUD de sensors
    Route::get('/sensors', [ControllerAPI::class, 'indexsen'])->name('sensors.index');
    Route::get('/sensors/create', [ControllerAPI::class, 'createsen'])->name('sensors.create');
    Route::post('/sensors', [ControllerAPI::class, 'storesen'])->name('sensors.store');
    Route::get('/sensors/{id}/edit', [ControllerAPI::class, 'editsen'])->name('sensors.edit');
    Route::put('/sensors/{id}', [ControllerAPI::class, 'updatesen'])->name('sensors.update');
    Route::delete('/sensors/{id}', [ControllerAPI::class, 'destroysen'])->name('sensors.destroy');
    Route::get('/sensors/pdf', [ControllerAPI::class, 'exportPdfsen'])->name('sensors.exportPdf');
    Route::get('/sensors/excel', [ControllerAPI::class, 'exportExcelsen'])->name('sensors.exportExcel');
    Route::get('/sensors/grafica', [ControllerAPI::class, 'showGraphsen'])->name('sensors.grafica');
    Route::post('/sensors/importar', [ControllerAPI::class, 'importExcelsen'])->name('sensors.importExcel');

    // CRUD de readings
    Route::get('/readings', [ControllerAPI::class, 'indexre'])->name('readings.index');
    Route::get('/readings/create', [ControllerAPI::class, 'createre'])->name('readings.create');
    Route::post('/readings', [ControllerAPI::class, 'storere'])->name('readings.store');
    Route::get('/readings/{id}/edit', [ControllerAPI::class, 'editre'])->name('readings.edit');
    Route::put('/readings/{id}', [ControllerAPI::class, 'updatere'])->name('readings.update');
    Route::delete('/readings/{id}', [ControllerAPI::class, 'destroyre'])->name('readings.destroy');
    Route::get('/readings/pdf', [ControllerAPI::class, 'exportPdfre'])->name('readings.exportPdf');
    Route::get('/readings/excel', [ControllerAPI::class, 'exportExcelre'])->name('readings.exportExcel');
    Route::get('/readings/grafica', [ControllerAPI::class, 'showGraphre'])->name('readings.grafica');
    Route::post('/readings/importar', [ControllerAPI::class, 'importExcelre'])->name('readings.importExcel');

    // CRUD de alerts
    Route::get('/alerts', [ControllerAPI::class, 'indexAlerts'])->name('alerts.index');
    Route::get('/alerts/create', [ControllerAPI::class, 'createAlert'])->name('alerts.create');
    Route::post('/alerts', [ControllerAPI::class, 'storeAlert'])->name('alerts.store');
    Route::get('/alerts/{id}/edit', [ControllerAPI::class, 'editAlert'])->name('alerts.edit');
    Route::put('/alerts/{id}', [ControllerAPI::class, 'updateAlert'])->name('alerts.update');
    Route::delete('/alerts/{id}', [ControllerAPI::class, 'destroyAlert'])->name('alerts.destroy');
    Route::get('/alerts/pdf', [ControllerAPI::class, 'exportPdfAlert'])->name('alerts.exportPdf');
    Route::get('/alerts/excel', [ControllerAPI::class, 'exportExcelAlert'])->name('alerts.exportExcel');
    Route::get('/alerts/grafica', [ControllerAPI::class, 'showGraphAlert'])->name('alerts.grafica');
    Route::post('/alerts/importar', [ControllerAPI::class, 'importExcelAlert'])->name('alerts.importExcel');
    });
});
