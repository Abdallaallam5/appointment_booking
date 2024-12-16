<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AppointmentController;

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




// الصفحة الرئيسية تعرض قائمة المواعيد
Route::get('/appointments', [AppointmentController::class, 'index'])->name('appointments.index');

// صفحة إنشاء حجز جديد
Route::get('/appointments/create', [AppointmentController::class, 'create'])->name('appointments.create');

require __DIR__.'/auth.php';
