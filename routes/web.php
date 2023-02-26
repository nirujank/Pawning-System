<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CarratageController;
use App\Http\Controllers\FetchDataController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\IssuingAmountController;
use App\Http\Controllers\UserController;
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
Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::get('/', function () {
    return view('welcome');
    });
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::resource('user',UserController::class);
    Route::resource('article',ArticleController::class);
    Route::resource('carrat',CarratageController::class);
    Route::resource('interest',InterestController::class);
    Route::resource('issue',IssuingAmountController::class);
    Route::get('fetcharticles',[FetchDataController::class,'articles'])->name('fetcharticles');
    Route::get('fetchcarrat',[FetchDataController::class,'carrat'])->name('fetchcarrat');
    Route::get('fetchInterset',[FetchDataController::class,'interest'])->name('fetchInterset');
    Route::get('fetchIssue',[FetchDataController::class,'issue'])->name('fetchIssue');

});

