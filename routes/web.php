<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileUpload;


Route::get('/', function () {
    return view('welcome');
});

Route::get('upload-file',[FileUpload::class,'createForm'])->name('showpage');
Route::post('upload-file',[FileUpload::class,'fileUpload'])->name('fileUpload');
Route::get('upload-file/{id}/download',[FileUpload::class,'fileDownload'])->name('fileDownload');
Route::delete('upload-file/{id}',[FileUpload::class,'deleteFile'])->name('deleteFile');
Route::get('upload-file/{id}/preview-mp3-files',[FileUpload::class,'filePreview'])->name('previewfiles');