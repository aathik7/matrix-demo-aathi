<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', 'login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::group(['prefix' => 'employee'],function () {
    Route::get('/index', [EmployeeController::class, 'index'])->name('employee.index');
    Route::get('/create', [EmployeeController::class, 'create'])->name('employee.create');
    Route::post('/store', [EmployeeController::class, 'store'])->name('employee.store');
    Route::get('/edit/{id}', [EmployeeController::class, 'edit'])->name('employee.edit');
    Route::post('/update', [EmployeeController::class, 'update'])->name('employee.update');
    Route::post('/destroy', [EmployeeController::class, 'destroy'])->name('employee.destroy');
    Route::get('/search', [EmployeeController::class, 'search'])->name('employee.search');
    Route::get('/employee-report', [EmployeeController::class, 'employeeExport'])->name('employee.report');
    Route::get('/employee-import', [EmployeeController::class, 'employeeImport'])->name('employee.import');
    Route::get('/template-download', [EmployeeController::class, 'templateDownload'])->name('template.download');
    Route::post('/employee-upload', [EmployeeController::class, 'employeeUpload'])->name('employee.upload');
});

require __DIR__.'/auth.php';
