<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    private $pedidos = [
        ['id' => 1, 'produto_id' => 1, 'usuario_id' => 1, 'quantidade' => 2],
        ['id' => 2, 'produto_id' => 2, 'usuario_id' => 2, 'quantidade' => 1],
    ];

    
}