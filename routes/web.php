<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    $no_of_lines = count(file(storage_path('logs/image.log'))) ;
    return view('index')->with('no_of_lines', $no_of_lines);
});

Route::get('/new', function () {
    $no_of_lines = count(file(storage_path('logs/image.log'))) ;
    return view('add');
});


Route::get("/i/img/result/{img}", function ($img) {
    $p = public_path("/img/result/$img");
    return response()->download($p);
});
