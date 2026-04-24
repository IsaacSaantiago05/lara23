<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CategoryApiController;
use App\Http\Controllers\Api\ProductApiController;

Route::apiResource('productos', ProductApiController::class)
    ->parameters(['productos' => 'product']);

Route::apiResource('categorias', CategoryApiController::class)
    ->parameters(['categorias' => 'category']);
