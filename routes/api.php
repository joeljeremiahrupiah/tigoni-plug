<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPaymentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::prefix('admin')->group(function () {
    // Route::post('/login', [AuthenticateController::class, 'login']);
    // Route::post('/register', [AuthenticateController::class, 'register']);

    // Route::middleware(['auth:sanctum', 'scope:admin'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::post('/login-vendor', [AuthenticateController::class, 'loginVendor']);
    Route::post('/register-vendor', [AuthenticateController::class, 'registerVendor']);

    Route::post('/logout', [AuthenticateController::class, 'logout']);

    Route::get('get-users', [UserController::class, 'getAllUsers']);
    Route::post('update-user-status/{id}', [UserController::class, 'updateUserStatus']);

    // Category CRUD Routes
    Route::get('get-categories', [CategoryController::class, 'index']);
    Route::post('create-categories', [CategoryController::class, 'store']);
    Route::post('update-categories/{category}', [CategoryController::class, 'update']);
    Route::delete('destroy-categories/{category}', [CategoryController::class, 'destroy']);
    // });

    Route::get('get-products/{userid}', [ProductController::class, 'index']);
    Route::post('create-products', [ProductController::class, 'store']);
    Route::post('update-products/{id}', [ProductController::class, 'update']);
    Route::delete('destroy-products/{id}', [ProductController::class, 'destroy']);

    Route::post('create-user-details', [AuthenticateController::class, 'createUserDetails']);
    Route::delete('delete-service-image/{id}', [ProductController::class, 'deleteServiceImage']);

    Route::get('purchase-subscription-callback', [AuthenticateController::class, 'purchaseSubscriptionCallback']);

    Route::get('purchase-product-callback', [ProductPaymentController::class, 'purchaseProductCallback']);

    Route::post('pay-for-product/{id}', [ProductPaymentController::class, 'payForProduct']);

    Route::post('process-profile-information/{id}', [UserController::class, 'processProfileInformation']);

    Route::get('get-admin-chat-data/{id}', [ChatController::class, 'getAdminChatData']);
});



Route::post('login-admin', [AuthenticateController::class, 'loginAdmin']);
Route::post('register-admin', [AuthenticateController::class, 'registerAdmin']);

Route::get('/', [AuthController::class, 'home']);
Route::get('/admin', [AuthenticateController::class, 'home']);

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::get('/get-categories', [CategoryController::class, 'getAllCategories']);
Route::get('/get-products', [ProductController::class, 'getAllProducts']);
Route::get('/get-paid-products', [ProductController::class, 'getAllPaidProducts']);
Route::get('/get-unpaid-products', [ProductController::class, 'getAllUnpaidProducts']);
Route::get('/get-product/{id}', [ProductController::class, 'getAllProduct']);

Route::get('get-admin-details', [UserController::class, 'getAdminDetails']);

Route::get('get-chat-data/{product_id}/{user_id}', [ChatController::class, 'getChatData']);
Route::get('get-all-chat-data/{user_id}', [ChatController::class, 'getAllChatData']);
Route::post('send-chat-message/{user_id}', [ChatController::class, 'sendMessage']);

Route::post('filtered-products/{category_id}', [ProductController::class, 'getFilteredProducts']);
Route::post('filter-all-products', [ProductController::class, 'filterProducts']);
Route::post('fetch-all-products', [ProductController::class, 'fetchAllProducts']);


Route::post('send-token', [AuthController::class, 'sendToken']);
Route::post('validate-token', [AuthController::class, 'validateToken']);
Route::post('reset-password', [AuthController::class, 'resetPassword']);
