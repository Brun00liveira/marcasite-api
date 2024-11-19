<?php

use App\Http\Controllers\Auth\{
    AuthController
};

use App\Http\Controllers\{
    UserController,
    RolePermissionController,
    CourseController,
    CategoryController,
    DashboardController,
    EnrollmentController,
    ExportController,
    CustomersAsaasController,
    PaymentAsaasController,
    SubscriptionController,
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

    Route::resources([
        'courses' => CourseController::class,
        'categories' => CategoryController::class,
        'enrollments' => EnrollmentController::class,
        'customers' => CustomersAsaasController::class
    ]);
});

Route::middleware(['auth:sanctum', 'role:user|admin'])->group(function () {
    Route::resource('users', UserController::class)->except(['destroy']);
    Route::post('/users/updatePhoto/{id}', [UserController::class, 'updatePhoto']);

    Route::resource('courses', CourseController::class)->except(['destroy']);
    Route::post('/courses/updatePhoto/{id}', [CourseController::class, 'updatePhoto']);

    Route::resource('categories', CategoryController::class)->only(['index', 'show']);
    Route::resource('enrollments', EnrollmentController::class)->except(['destroy']);
    Route::get('/dashboard', [DashboardController::class, 'getDashboardData']);
    Route::resource('customers', CustomersAsaasController::class)->except(['destroy']);
    Route::resource('payment', PaymentAsaasController::class)->except(['destroy']);
    Route::resource('subscription', SubscriptionController::class)->except(['destroy']);
});
Route::get('/export', [ExportController::class, 'export']);
Route::get('/export-pdf', [ExportController::class, 'exportPdf']);
Route::post('asaas/webhook', [SubscriptionController::class, 'asaasWebhook']);
