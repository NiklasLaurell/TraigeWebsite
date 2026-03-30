<?php

use App\Http\Controllers\VisitController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware('auth')->group(function (): void {
    Route::get('/dashboard', fn () => Inertia::render('Dashboard'))->name('dashboard');
    Route::get('/visits/create', fn () => Inertia::render('Visits/RegisterPatient'))->name('visits.create');
    Route::post('/visits', [VisitController::class, 'store'])->name('visits.store');
    Route::post('/visits/{visit}/measurement-decisions', [VisitController::class, 'generateMeasurementDecision'])->name('visits.measurement-decisions.store');
    Route::post('/visits/{visit}/triage-predictions', [VisitController::class, 'generateTriagePrediction'])->name('visits.triage-predictions.store');
    Route::get('/visits/{visit}/priority', [VisitController::class, 'editPriority'])->name('visits.priority.edit');
    Route::patch('/visits/{visit}/priority', [VisitController::class, 'updatePriority'])->name('visits.priority.update');
    Route::get('/visits', [VisitController::class, 'index'])->name('visits.index');
});
