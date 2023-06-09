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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::post('/login',[AuthController::class,'login']);
// Route::get('/logout',[AuthController::class,'logout'])->middleware(['auth:sanctum']);

// Route::prefix('/products')->group(function () {
//     Route::get('/',[ProductController::class,'index'])->middleware(['auth:sanctum']);
//     Route::get('/{id}',[ProductController::class,'show'])->middleware(['auth:sanctum']);
//     Route::post('/',[ProductController::class,'store'])->middleware(['auth:sanctum']);
//     Route::post('/{id}',[ProductController::class,'update'])->middleware(['auth:sanctum']);
//     Route::delete('/{id}',[ProductController::class,'destroy'])->middleware(['auth:sanctum']);
// });

// Route::prefix('/category')->group(function () {
//     Route::get('/',[CategoryController::class,'index'])->middleware(['auth:sanctum']);
//     Route::post('/',[CategoryController::class,'store'])->middleware(['auth:sanctum']);
//     Route::post('/{id}',[CategoryController::class,'update'])->middleware(['auth:sanctum']);
//     Route::delete('/{id}',[CategoryController::class,'destroy'])->middleware(['auth:sanctum']);
// });

// Route::prefix('/orders')->group(function () {
//     Route::get('/',[OrderController::class,'index'])->middleware(['auth:sanctum']);
//     Route::post('/',[OrderController::class,'store'])->middleware(['auth:sanctum']);
//     Route::post('/{id}',[OrderController::class,'update'])->middleware(['auth:sanctum']);
//     Route::delete('/{id}',[OrderController::class,'destroy'])->middleware(['auth:sanctum']);
// });

// Route::prefix('/carts')->group(function () {
//     Route::get('/',[CartController::class,'index'])->middleware(['auth:sanctum']);
//     Route::post('/',[CartController::class,'store'])->middleware(['auth:sanctum']);
//     Route::post('/{id}',[CartController::class,'update'])->middleware(['auth:sanctum']);
//     Route::delete('/{id}',[CartController::class,'destroy'])->middleware(['auth:sanctum']);
// });

// Route::prefix('/category-edu')->group(function () {
//     Route::get('/',[CategoryEducationController::class,'index'])->middleware(['auth:sanctum']);
//     Route::post('/',[CategoryEducationController::class,'store'])->middleware(['auth:sanctum']);
//     Route::post('/{id}',[CategoryEducationController::class,'update'])->middleware(['auth:sanctum']);
//     Route::delete('/{id}',[CategoryEducationController::class,'destroy'])->middleware(['auth:sanctum']);
// });


Route::post('/login',[AuthController::class,'login']);
Route::get('/logout',[AuthController::class,'logout'])->middleware(['auth:sanctum']);
Route::post('/register',[AuthController::class,'register']);

Route::prefix('/products')->group(function () {
    Route::get('/',[ProductController::class,'index']);
    Route::get('/{id}',[ProductController::class,'show']);
    Route::get('/category/{id_category}',[ProductController::class,'showByCategory']);
    Route::get('/images/{filename}',[ProductController::class,'getImage']);
    Route::post('/',[ProductController::class,'store']);
    Route::post('/{id}',[ProductController::class,'update']);
    Route::delete('/{id}',[ProductController::class,'destroy']);
});

Route::prefix('/category')->group(function () {
    Route::get('/',[CategoryController::class,'index']);
    Route::post('/',[CategoryController::class,'store']);
    Route::post('/{id}',[CategoryController::class,'update']);
    Route::delete('/{id}',[CategoryController::class,'destroy']);
});

Route::prefix('/orders')->group(function () {
    Route::get('/',[OrderController::class,'index']);
    Route::post('/',[OrderController::class,'store']);
    Route::post('/{id}',[OrderController::class,'update']);
    Route::delete('/{id}',[OrderController::class,'destroy']);
});

Route::prefix('/carts')->group(function () {
    Route::get('/',[CartController::class,'index']);
    Route::post('/',[CartController::class,'store']);
    Route::post('/{id}',[CartController::class,'update']);
    Route::delete('/{id}',[CartController::class,'destroy']);
});

Route::prefix('/category-edu')->group(function () {
    Route::get('/',[CategoryEducationController::class,'index']);
    Route::post('/',[CategoryEducationController::class,'store']);
    Route::post('/{id}',[CategoryEducationController::class,'update']);
    Route::delete('/{id}',[CategoryEducationController::class,'destroy']);
});


Route::prefix('/paket')->group(function () {
    Route::get('/',[PaketController::class,'index']);
    Route::get('/{id}',[PaketController::class,'show']);
    Route::post('/',[PaketController::class,'store']);
    Route::post('/{id}',[PaketController::class,'update']);
    Route::delete('/{id}',[PaketController::class,'destroy']);
});

Route::prefix('/education')->group(function () {
    Route::get('/',[EducationController::class,'index']);
    Route::get('/{id}',[EducationController::class,'show']);
    Route::get('/video/{video_path}',[EducationController::class,'getVideo']);
    Route::post('/',[EducationController::class,'store']);
    Route::post('/{id}',[EducationController::class,'update']);
    Route::delete('/{id}',[EducationController::class,'destroy']);
});


Route::prefix('/reviews')->group(function () {
    Route::get('/',[ReviewController::class,'index']);
    Route::get('/{id}',[ReviewController::class,'show']);
    Route::post('/',[ReviewController::class,'store']);
    Route::post('/{id}',[ReviewController::class,'update']);
    Route::delete('/{id}',[ReviewController::class,'destroy']);
});


