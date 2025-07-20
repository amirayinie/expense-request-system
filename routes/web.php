<?php

use App\Http\Controllers\ExpenseRequestController;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('expense-requests', ExpenseRequestController::class);

Route::get('expense-requests/{id}/download', [ExpenseRequestController::class, 'download'])
    ->name('expense-requests.download');

Route::post('expense-requests/groupUpdate',[ExpenseRequestController::class, 'groupUpdate'])
    ->name('expense-requests.groupUpdate');

    
Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
Route::post('/payments/manual', [PaymentController::class, 'manualPay'])->name('payments.manual');