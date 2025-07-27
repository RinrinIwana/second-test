<?php

use Illuminate\Support\Facades\Route;
// routes/web.php
use App\Http\Controllers\ProductController;

// 商品一覧
Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// 商品登録
Route::get('/products/register', [ProductController::class, 'create'])->name('products.create');
Route::post('/products/register', [ProductController::class, 'store'])->name('products.store');

// 商品表示・編集・更新・削除
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
Route::post('/products/{product}/update', [ProductController::class, 'update'])->name('products.update'); // ★
Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');