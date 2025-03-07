<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileUpload;


Route::get('/', function () {
    return view('welcome');
});

Route::get('upload-file',[FileUpload::class,'createForm']);
Route::post('upload-file',[FileUpload::class,'fileUpload'])->name('fileUpload');
Route::get('upload-file/{id}/download',[FileUpload::class,'fileDownload'])->name('fileDownload');