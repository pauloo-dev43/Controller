<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OrderController;

// Rotas para Produtos
Route::get('/produtos', [ProductController::class, 'index'])->name('produtos.index'); // Listar todos
Route::get('/produtos/criar', [ProductController::class, 'create'])->name('produtos.create'); // Exibir formulário de criação
Route::post('/produtos', [ProductController::class, 'store'])->name('produtos.store'); // Salvar novo produto
Route::get('/produtos/{id}/exibir', [ProductController::class, 'show'])->name('produtos.show'); // Exibir um produto específico
Route::get('/produtos/{id}/editar', [ProductController::class, 'edit'])->name('produtos.edit'); // Exibir formulário de edição
Route::put('/produtos/{id}', [ProductController::class, 'update'])->name('produtos.update'); // Atualizar um produto
Route::delete('/produtos/{id}', [ProductController::class, 'destroy'])->name('produtos.destroy'); // Apagar um produto

// Rotas para Usuários
Route::get('/usuarios', [UserController::class, 'index'])->name('usuarios.index');
Route::get('/usuarios/criar', [UserController::class, 'create'])->name('usuarios.create');
Route::post('/usuarios', [UserController::class, 'store'])->name('usuarios.store');
Route::get('/usuarios/{id}/exibir', [UserController::class, 'show'])->name('usuarios.show');
Route::get('/usuarios/{id}/editar', [UserController::class, 'edit'])->name('usuarios.edit');
Route::put('/usuarios/{id}', [UserController::class, 'update'])->name('usuarios.update');
Route::delete('/usuarios/{id}', [UserController::class, 'destroy'])->name('usuarios.destroy');

// Rotas para Pedidos
Route::get('/pedidos', [OrderController::class, 'index'])->name('pedidos.index');
Route::get('/pedidos/criar', [OrderController::class, 'create'])->name('pedidos.create');
Route::post('/pedidos', [OrderController::class, 'store'])->name('pedidos.store');
Route::get('/pedidos/{id}/exibir', [OrderController::class, 'show'])->name('pedidos.show');
Route::get('/pedidos/{id}/editar', [OrderController::class, 'edit'])->name('pedidos.edit');
Route::put('/pedidos/{id}', [OrderController::class, 'update'])->name('pedidos.update');
Route::delete('/pedidos/{id}', [OrderController::class, 'destroy'])->name('pedidos.destroy');

Route::get('/', function () {
    return 'Bem-vindo a Paulão Variedades';
});