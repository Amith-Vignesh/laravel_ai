<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProfileController;

require __DIR__.'/auth.php';


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
    Route::get('/chat', function () {
        return view('chat');
    });
    Route::post('/openai', [ChatController::class, '__invoke']);

    Route::get('/file-upload', [FileController::class, 'index'])->name('file.upload.form');
    Route::post('/file-upload', [FileController::class, 'store'])->name('file.upload');
    Route::get('/file/download/{fileId}', [FileController::class, 'download'])->name('file.download');

    Route::delete('/file/delete/{fileId}', [FileController::class, 'destroy'])->name('file.destroy');

});
