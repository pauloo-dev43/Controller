<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $produtos = [
        ['id' => 1, 'nome' => 'Produto A', 'preco' => 10.00],
        ['id' => 2, 'nome' => 'Produto B', 'preco' => 20.00],
    ];

    public function index()
    {
        return response()->json($this->produtos);
    }

    public function show($id)
    {
        $produto = array_filter($this->produtos, function ($produto) use ($id) {
            return $produto['id'] == $id;
        });

        return response()->json(array_values($produto));
    }

    public function store(Request $request)
    {
        $novoProduto = $request->all();
        $this->produtos[] = $novoProduto;

        return response()->json($novoProduto, 201);
    }

    public function update(Request $request, $id)
    {
        $produtoAtualizado = $request->all();
        $this->produtos = array_map(function ($produto) use ($id, $produtoAtualizado) {
            if ($produto['id'] == $id) {
                return $produtoAtualizado;
            }
            return $produto;
        }, $this->produtos);

        return response()->json($produtoAtualizado);
    }

    public function destroy($id)
    {
        $this->produtos = array_filter($this->produtos, function ($produto) use ($id) {
            return $produto['id'] != $id;
        });

        return response()->json(null, 204);
    }
}