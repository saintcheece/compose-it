<?php

use Illuminate\Support\Facades\Route;

Route::post('/generate-image/generateFace', [App\Http\Controllers\GenerateImageController::class, 'generateFace'])->name('generate-image.generateFace');

Route::get('/', function () {
    return view('index');
});