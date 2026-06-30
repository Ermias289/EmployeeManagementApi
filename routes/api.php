<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\DepartmentController;
use App\Http\Controllers\Api\V1\EmployeeController;



Route::prefix('v1')->group(function () {
    Route::get('/test', function () {
    return response()->json(['message' => 'API is working']);
    });
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    Route::delete('/user', [AuthController::class, 'destroy'])->middleware('auth:api');
    Route::delete('/user/{id}', [AuthController::class, 'destroyUserAdmin']);

    // Route::middleware('auth:api')->group(function () {
        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::apiResource('department', DepartmentController::class);
        Route::apiResource('employee', EmployeeController::class);   
    // });
});
?>