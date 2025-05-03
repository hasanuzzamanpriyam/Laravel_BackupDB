<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BackupController;

Route::get('/', [BackupController::class, 'show'])->name('backup.show');
Route::post('/backup/run', [BackupController::class, 'run'])->name('backup.run');
