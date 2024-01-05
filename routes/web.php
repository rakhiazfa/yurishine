<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MedicalRecordController;
use App\Http\Controllers\MedicineController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\PolyclinicController;
use App\Http\Controllers\TreatmentController;
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

Route::get('/', HomeController::class)->name('home');

Route::middleware('auth')->get('/dashboard', DashboardController::class)->name('dashboard');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {

    Route::inertia('/login', 'auth/Login')->name('login');

    Route::post('/login', LoginController::class);
});

Route::middleware('auth')->get('/logout', LogoutController::class)->name('logout');


Route::middleware('auth')->group(function () {

    Route::resource('/polyclinics', PolyclinicController::class);

    Route::resource('/doctors', DoctorController::class);

    Route::resource('/patients', PatientController::class);

    Route::resource('/medicines', MedicineController::class);

    Route::resource('/treatments', TreatmentController::class);

    Route::resource('/medical-records', MedicalRecordController::class);
});
