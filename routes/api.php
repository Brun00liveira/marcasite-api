<?php

use App\Http\Controllers\Auth\{
    AuthController
};

use App\Http\Controllers\{
    UserController,
    RolePermissionController,
    CourseController,
    CategoryController
};

use Illuminate\Support\Facades\Route;


Route::post('/create', [AuthController::class, 'register']);

Route::post('/login', [AuthController::class, 'login']);
Route::post('/password/forgot', [AuthController::class, 'sendResetLinkEmail'])->name('password.reset');
Route::post('/password/reset', [AuthController::class, 'reset']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {

    Route::post('/roles', [RolePermissionController::class, 'createRole']);
    Route::post('/permissions', [RolePermissionController::class, 'createPermission']);
    Route::post('/roles/role-permission', [RolePermissionController::class, 'assignPermissionToRole']);

    Route::prefix('users')->group(function () {
        Route::post('/assign-role', [RolePermissionController::class, 'assignRoleToUser']);
        Route::post('/assign-permission', [RolePermissionController::class, 'assignPermissionToUser']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });

    Route::prefix('courses')->group(function () {
        Route::post('', [CourseController::class, 'store']);
        Route::put('/{id}', [CourseController::class, 'update']);
        Route::delete('{id}', [CourseController::class, 'destroy']);
    });

    Route::prefix('categories')->group(function () {
        Route::post('/', [CategoryController::class, 'store']);
        Route::put('/{id}', [CategoryController::class, 'update']);
        Route::delete('/{id}', [CategoryController::class, 'destroy']);
    });
});

Route::middleware(['auth:sanctum', 'role:user|admin'])->group(function () {

    Route::prefix('users')->group(function () {
        Route::get('', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
        Route::post('', [UserController::class, 'store']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::post('/updatePhoto/{id}', [UserController::class, 'updatePhoto']);
    });

    Route::prefix('courses')->group(function () {
        Route::get('/', [CourseController::class, 'index']);
        Route::get('/{id}', [CourseController::class, 'show']);
        Route::put('/{id}', [CourseController::class, 'update']);
        Route::post('/updatePhoto/{id}', [CourseController::class, 'updatePhoto']);
    });

    Route::prefix('categories')->group(function () {
        Route::get('/', [CategoryController::class, 'index']);
        Route::get('/{id}', [CategoryController::class, 'show']);
    });
});
