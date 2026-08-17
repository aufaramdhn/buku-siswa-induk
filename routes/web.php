<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\ExtracurricularController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuditLogController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login', [AuthController::class, 'authenticate']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/quick-search', [DashboardController::class, 'quickSearch'])->name('quick_search');

    Route::get('/students/all-students-print', [StudentController::class, 'allStudentsPrint'])->name('students.all_students_print');
    Route::get('/students/export-pdf', [StudentController::class, 'allStudentsPrint'])->name('students.export.pdf');
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/create', [StudentController::class, 'create'])->name('students.create');
    Route::post('/students', [StudentController::class, 'store'])->name('students.store');
    Route::get('/students/{id}/edit', [StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{id}', [StudentController::class, 'update'])->name('students.update');
    Route::delete('/students/{id}', [StudentController::class, 'destroy'])->name('students.destroy');
    Route::get('/students/{id}/single-student-print', [StudentController::class, 'singleStudentPrint'])->name('students.single_student_print');
    Route::get('/students/{id}/print', [StudentController::class, 'singleStudentPrint'])->name('students.print');

    Route::middleware('can:admin-only')->group(function () {
        Route::get('/settings', [SchoolController::class, 'edit'])->name('settings.edit');
        Route::post('/settings', [SchoolController::class, 'update'])->name('settings.update');

        Route::get('/subjects', [SubjectController::class, 'index'])->name('subjects.index');
        Route::post('/subjects', [SubjectController::class, 'store'])->name('subjects.store');
        Route::delete('/subjects/{id}', [SubjectController::class, 'destroy'])->name('subjects.destroy');

        Route::get('/extracurriculars', [ExtracurricularController::class, 'index'])->name('extracurriculars.index');
        Route::post('/extracurriculars', [ExtracurricularController::class, 'store'])->name('extracurriculars.store');
        Route::delete('/extracurriculars/{id}', [ExtracurricularController::class, 'destroy'])->name('extracurriculars.destroy');

        Route::get('/operators', [UserController::class, 'index'])->name('users.index');
        Route::post('/operators', [UserController::class, 'store'])->name('users.store');
        Route::put('/operators/{id}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/operators/{id}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::get('/audit-logs', [AuditLogController::class, 'index'])->name('audit_logs.index');
    });
});
