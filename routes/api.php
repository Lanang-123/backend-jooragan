<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CategoryEducationController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PaketController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\TokoController;
use App\Http\Resources\ReviewResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->middleware(['auth:sanctum']);
Route::get('/me', [AuthController::class, 'me'])->middleware(['auth:sanctum']);
Route::post('/register', [AuthController::class, 'register']);

Route::prefix('/products')->group(function () {
    Route::get('/', [ProductController::class, 'index']);
    Route::get('/{id}', [ProductController::class, 'show']);
    Route::get('/category/{id_category}', [ProductController::class, 'showByCategory']);
    Route::get('/images/{filename}', [ProductController::class, 'getImage']);
    Route::get('/name/{productName}', [ProductController::class, 'showByName']);
    Route::post('/{id_category}', [ProductController::class, 'store'])->middleware(['auth:sanctum']);
    Route::post('/update/{id}', [ProductController::class, 'update'])->middleware(['auth:sanctum']);
    Route::get('/delete/{id}', [ProductController::class, 'destroy'])->middleware(['auth:sanctum']);
});

Route::prefix('/category')->group(function () {
    Route::get('/', [CategoryController::class, 'index']);
    Route::get('/icons/{filename}', [CategoryController::class, 'getIcons']);
    Route::post('/', [CategoryController::class, 'store'])->middleware(['auth:sanctum']);
    Route::post('/{id}', [CategoryController::class, 'update'])->middleware(['auth:sanctum']);
    Route::delete('/{id}', [CategoryController::class, 'destroy'])->middleware(['auth:sanctum']);
});

Route::prefix('/orders')->group(function () {
    Route::get('/', [OrderController::class, 'index']);
    Route::post('/', [OrderController::class, 'store'])->middleware(['auth:sanctum']);
    Route::post('/{id}', [OrderController::class, 'update'])->middleware(['auth:sanctum']);
    Route::delete('/{id}', [OrderController::class, 'destroy'])->middleware(['auth:sanctum']);
});

Route::prefix('/carts')->group(function () {
    Route::get('/', [CartController::class, 'index']);
    Route::get('/me-cart', [CartController::class, 'showByUser'])->middleware(['auth:sanctum']);;
    Route::post('/', [CartController::class, 'store'])->middleware(['auth:sanctum']);
    Route::post('/{id}', [CartController::class, 'update'])->middleware(['auth:sanctum']);
    Route::delete('/{id}', [CartController::class, 'destroy'])->middleware(['auth:sanctum']);
});

Route::prefix('/category-edu')->group(function () {
    Route::get('/', [CategoryEducationController::class, 'index']);
    Route::get('/images/{filename}', [CategoryEducationController::class, 'getImage']);
    Route::post('/', [CategoryEducationController::class, 'store'])->middleware(['auth:sanctum']);
    Route::post('/{id}', [CategoryEducationController::class, 'update'])->middleware(['auth:sanctum']);
    Route::delete('/{id}', [CategoryEducationController::class, 'destroy'])->middleware(['auth:sanctum']);
});


Route::prefix('/paket')->group(function () {
    Route::get('/', [PaketController::class, 'index']);
    Route::get('/{id}', [PaketController::class, 'show']);
    Route::post('/{id_product}', [PaketController::class, 'store'])->middleware(['auth:sanctum']);
    Route::post('/update/{id}', [PaketController::class, 'update'])->middleware(['auth:sanctum']);
    Route::get('/delete/{id}', [PaketController::class, 'destroy'])->middleware(['auth:sanctum']);
});


Route::prefix('/education')->group(function () {
    Route::get('/', [EducationController::class, 'index']);
    Route::get('/{id}', [EducationController::class, 'show']);
    Route::get('/category/{id}', [EducationController::class, 'showByCategory']);
    Route::get('/video/{video_path}', [EducationController::class, 'getVideo']);
    Route::post('/', [EducationController::class, 'store'])->middleware(['auth:sanctum']);
    Route::post('/{id}', [EducationController::class, 'update'])->middleware(['auth:sanctum']);
    Route::delete('/{id}', [EducationController::class, 'destroy'])->middleware(['auth:sanctum']);
});


Route::prefix('/reviews')->group(function () {
    Route::get('/', [ReviewController::class, 'index']);
    Route::get('/{id}', [ReviewController::class, 'show']);
    Route::post('/', [ReviewController::class, 'store'])->middleware(['auth:sanctum']);
    Route::post('/{id}', [ReviewController::class, 'update'])->middleware(['auth:sanctum']);
    Route::delete('/{id}', [ReviewController::class, 'destroy'])->middleware(['auth:sanctum']);
});

Route::prefix('/toko')->group(function () {
    Route::get('/', [TokoController::class, 'index']);
    Route::get('/icons/{filename}', [TokoController::class, 'getIcons']);
    Route::get('/mou/{filename}', [TokoController::class, 'getPDF']);
    Route::get('/owner', [TokoController::class, 'showByOwner'])->middleware(['auth:sanctum']);
    Route::post('/', [TokoController::class, 'store'])->middleware(['auth:sanctum']);
    Route::post('/{id}', [TokoController::class, 'update'])->middleware(['auth:sanctum']);
    Route::get('/delete/{id}', [TokoController::class, 'destroy'])->middleware(['auth:sanctum']);
});
