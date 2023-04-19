<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CarratageController;
use App\Http\Controllers\FetchDataController;
use App\Http\Controllers\InterestController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\IssuingAmountController;
use App\Http\Controllers\ReportController;
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
    Route::get('fetchUser',[FetchDataController::class,'user'])->name('fetchUser');
    Route::get('fetchinvoice',[FetchDataController::class,'invoice'])->name('fetchinvoice');
    Route::get('profile',[UserController::class,'profile'])->name('profile');
    Route::get('invoice',[InvoiceController::class,'index'])->name('invoice');
    Route::get('getInvoice',[InvoiceController::class,'getInvoice'])->name('invoice.getInvoice');
    Route::get('view_invoice',[InvoiceController::class,'view'])->name('invoice.view');
    Route::get('get-carratage',[InvoiceController::class,'getcarratage'])->name('invoice.getcarratage');
    Route::post('saveInvoice',[InvoiceController::class,'saveInvoice'])->name('invoice.saveInvoice');
    Route::post('savePayment',[InvoiceController::class,'savePayment'])->name('invoice.savePayment');
    Route::get('pdf/{id}',[InvoiceController::class,'pdf'])->name('invoice.pdf');
    Route::resource('report',ReportController::class);
    Route::get('fetchReport',[FetchDataController::class,'report'])->name('fetchReport');





});

