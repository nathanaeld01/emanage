<?php

use Illuminate\Support\Facades\Route;
use Modules\Employees\Http\Controllers\EmployeeController;

Route::middleware(['api'])->prefix('api')->group(function () {
    Route::apiResource('/employees', EmployeeController::class);
});
