<?php

use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\CostCenterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\GadgetModelController;
use App\Http\Controllers\ReportController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('employees', EmployeeController::class);
Route::resource('cost-centers', CostCenterController::class);
Route::resource('equipment', EquipmentController::class);
Route::resource('assignments', AssignmentController::class);
Route::patch('assignments/{assignment}/return', [AssignmentController::class, 'return'])
    ->name('assignments.return');
Route::resource('gadget-models', GadgetModelController::class);

Route::prefix('reports')->group(function () {
    Route::get('/', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/equipment', [ReportController::class, 'equipmentReport'])->name('reports.equipment');
    Route::get('/employees', [ReportController::class, 'employeeReport'])->name('reports.employees');
    Route::get('/assignments', [ReportController::class, 'assignmentReport'])->name('reports.assignments');
});