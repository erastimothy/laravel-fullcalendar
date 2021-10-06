<?php

use App\Http\Controllers\EventController;
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
    return view('events');
});
Route::get('events',[EventController::class,'index'])->name('events.index');
Route::post('events',[EventController::class,'store'])->name('events.store');
Route::put('events',[EventController::class,'update'])->name('events.update');
Route::delete('events',[EventController::class,'destroy'])->name('events.destroy');