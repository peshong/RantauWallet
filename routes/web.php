<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LogController;
use App\Http\Controllers\ReportController;  // <-- tambahin titik koma
use App\Http\Controllers\BillController;

Route::post('/bills/{bill}/remind', [BillController::class, 'remind'])->name('bills.remind');

Route::resource('bills', BillController::class)->middleware('auth');
Route::post('/bills/{bill}/pay', [BillController::class, 'pay'])->name('bills.pay')->middleware('auth');

Route::get('/report/download', [ReportController::class, 'download'])->name('report.download');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::resource('categories', CategoryController::class)->middleware('auth');

Route::resource('transactions', TransactionController::class)->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/password', [ProfileController::class, 'editPassword'])->name('profile.password');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    Route::get('/log', [LogController::class, 'index'])->name('log.index');
    Route::get('/report', [ReportController::class, 'index'])->name('report.index');
    Route::get('/report/download', [ReportController::class, 'download'])->name('report.download');
});

require __DIR__.'/auth.php';