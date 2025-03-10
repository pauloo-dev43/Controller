<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

// Rotas para Produtos
Route::get('/produtos', [ProductController::class, 'index']);
Route::get('/produtos/{id}', [ProductController::class, 'show']);
Route::post('/produtos', [ProductController::class, 'store']);
Route::put('/produtos/{id}', [ProductController::class, 'update']);
Route::delete('/produtos/{id}', [ProductController::class, 'destroy']);

// Rotas para Usuários
Route::get('/usuarios', [UserController::class, 'index']);
Route::get('/usuarios/{id}', [UserController::class, 'show']);
Route::post('/usuarios', [UserController::class, 'store']);
Route::put('/usuarios/{id}', [UserController::class, 'update']);
Route::delete('/usuarios/{id}', [UserController::class, 'destroy']);

// Rotas para Pedidos
Route::get('/pedidos', [OrderController::class, 'index']);
Route::get('/pedidos/{id}', [OrderController::class, 'show']);
Route::post('/pedidos', [OrderController::class, 'store']);
Route::put('/pedidos/{id}', [OrderController::class, 'update']);
Route::delete('/pedidos/{id}', [OrderController::class, 'destroy']);
