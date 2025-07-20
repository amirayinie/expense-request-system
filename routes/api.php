<?php

use App\Http\Controllers\Api\ExpenseRequestApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::resource('expense-requests',ExpenseRequestApiController::class);
});

