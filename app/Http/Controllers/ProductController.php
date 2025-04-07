<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    protected $produtos = []; // Simulação de banco de dados

    public function __construct()
    {
        $this->produtos = [
            1 => ['nome' => 'Produto A', 'descricao' => 'Descrição do Produto A'],
            2 => ['nome' => 'Produto B', 'descricao' => 'Descrição do Produto B'],
        ];
    }

    public function index()
    {
        $output = "<h2>Lista de Produtos</h2><ul>";
        foreach ($this->produtos as $id => $produto) {
            $output .= "<li><a href='" . route('produtos.show', ['id' => $id]) . "'>" . $produto['nome'] . "</a></li>";
        }
        $output .= "</ul><p><a href='" . route('produtos.create') . "'>Adicionar Produto</a></p>";
        return $output;
    }

    public function create()
    {
        return "<h2>Criar Novo Produto</h2><form method='POST' action='" . route('produtos.store') . "'>
            <input type='hidden' name='_token' value='" . csrf_token() . "'>
            Nome: <input type='text' name='nome'><br><br>
            Descrição: <textarea name='descricao'></textarea><br><br>
            <input type='submit' value='Salvar'>
        </form>";
    }

    public function store(Request $request)
    {
        // Simulação de salvar no banco de dados
        $novoId = count($this->produtos) + 1;
        $this->produtos[$novoId] = ['nome' => $request->input('nome'), 'descricao' => $request->input('descricao')];
        return redirect()->route('produtos.index')->with('mensagem', 'Produto criado com sucesso!');
    }

    public function show($id)
    {
        if (isset($this->produtos[$id])) {
            return "<h2>Detalhes do Produto</h2>
                    <p><strong>ID:</strong> " . $id . "</p>
                    <p><strong>Nome:</strong> " . $this->produtos[$id]['nome'] . "</p>
                    <p><strong>Descrição:</strong> " . $this->produtos[$id]['descricao'] . "</p>
                    <p><a href='" . route('produtos.edit', ['id' => $id]) . "'>Editar</a> |
                    <form method='POST' action='" . route('produtos.destroy', ['id' => $id]) . "' style='display:inline'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button type='submit' onclick='return confirm(\"Tem certeza que deseja apagar?\")'>Apagar</button>
                    </form> |
                    <a href='" . route('produtos.index') . "'>Voltar</a></p>";
        } else {
            return "Produto não encontrado.";
        }
    }

    public function edit($id)
    {
        if (isset($this->produtos[$id])) {
            return "<h2>Editar Produto</h2>
                    <form method='POST' action='" . route('produtos.update', ['id' => $id]) . "'>
                        <input type='hidden' name='_method' value='PUT'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        Nome: <input type='text' name='nome' value='" . $this->produtos[$id]['nome'] . "'><br><br>
                        Descrição: <textarea name='descricao'>" . $this->produtos[$id]['descricao'] . "</textarea><br><br>
                        <input type='submit' value='Atualizar'> |
                        <a href='" . route('produtos.index') . "'>Voltar</a>
                    </form>";
        } else {
            return "Produto não encontrado.";
        }
    }

    public function update(Request $request, $id)
    {
        if (isset($this->produtos[$id])) {
            $this->produtos[$id]['nome'] = $request->input('nome');
            $this->produtos[$id]['descricao'] = $request->input('descricao');
            return redirect()->route('produtos.show', ['id' => $id])->with('mensagem', 'Produto atualizado com sucesso!');
        } else {
            return "Produto não encontrado.";
        }
    }

    public function destroy($id)
    {
        if (isset($this->produtos[$id])) {
            unset($this->produtos[$id]);
            return redirect()->route('produtos.index')->with('mensagem', 'Produto apagado com sucesso!');
        } else {
            return "Produto não encontrado.";
        }
    }
}