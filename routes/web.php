<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Livewire\Content;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
 
// Route::get('/content', Content::class);
Route::get('/login/{slug?}', [IndexController::class, 'login'])->name('login')->where('slug', '.*'); 
Route::post('/signin', [IndexController::class, 'signin'])->name('signin'); 
Route::get('/{slug?}', [IndexController::class, 'index'])->name('index')->where('slug', '.*'); 
Route::post('update-content', [IndexController::class, 'updateContent'])->name('update-content');
Route::post('update-url', [IndexController::class, 'updateUrl'])->name('update-url');
Route::post('add-password', [IndexController::class, 'addPassword'])->name('add-password');
Route::post('remove-password', [IndexController::class, 'removePassword'])->name('remove-password');
Route::post('remove-file', [IndexController::class, 'removeFile'])->name('remove-file');


Route::get('upload-ui', [IndexController::class, 'uploadUi' ]);
Route::post('file-upload', [IndexController::class, 'FileUpload' ])->name('FileUpload');
Route::post('logout', [IndexController::class, 'logout' ])->name('logout');
