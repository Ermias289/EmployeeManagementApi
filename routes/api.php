<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\DepartmentController;
use App\Http\Controllers\Api\V1\EmployeeController;
// use App\Http\Controllers\Api\V1\AuthController;

Route::prefix('v1')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {

        Route::get('/me', [AuthController::class, 'me']);
        Route::post('/logout', [AuthController::class, 'logout']);

        Route::apiResource('department', DepartmentController::class);

        Route::apiResource('employee', EmployeeController::class)
            ->middleware([
                'index'   => 'permission:employee.view',
                'store'   => 'permission:employee.create',
                'update'  => 'permission:employee.update',
                'destroy' => 'permission:employee.delete',
            ]);

        Route::delete('/user/{id}', [AuthController::class, 'destroyUserAdmin']);
        Route::delete('/user', [AuthController::class, 'destroy']);
        Route::get('/refresh-token', [AuthController::class, 'refreshToken']);
        Route::post('/users/{user}/assign-role', [AuthController::class, 'assignRole']);
    });
});
?>