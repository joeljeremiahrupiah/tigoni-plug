<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/', function () {
//     return view('app');
// })
// ->name('application');


Route::get('/admin/{vue_capture?}', function () {
    return view('admin.admin_master');
})->where('vue_capture', '[\/\w\.-]*');

Route::get('/{vue_capture?}', function () {
    return view('app');
})->where('vue_capture', '[\/\w\.-]*');
