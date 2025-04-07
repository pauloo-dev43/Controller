<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $usuarios = []; // Simulação de banco de dados

    public function __construct()
    {
        $this->usuarios = [
            1 => ['nome' => 'João Silva', 'email' => 'joao@exemplo.com'],
            2 => ['nome' => 'Maria Souza', 'email' => 'maria@exemplo.com'],
        ];
    }

    public function index()
    {
        $output = "<h2>Lista de Usuários</h2><ul>";
        foreach ($this->usuarios as $id => $usuario) {
            $output .= "<li><a href='" . route('usuarios.show', ['id' => $id]) . "'>" . $usuario['nome'] . "</a></li>";
        }
        $output .= "</ul><p><a href='" . route('usuarios.create') . "'>Adicionar Usuário</a></p>";
        return $output;
    }

    public function create()
    {
        return "<h2>Criar Novo Usuário</h2><form method='POST' action='" . route('usuarios.store') . "'>
            <input type='hidden' name='_token' value='" . csrf_token() . "'>
            Nome: <input type='text' name='nome'><br><br>
            Email: <input type='email' name='email'><br><br>
            <input type='submit' value='Salvar'>
        </form>";
    }

    public function store(Request $request)
    {
        $novoId = count($this->usuarios) + 1;
        $this->usuarios[$novoId] = ['nome' => $request->input('nome'), 'email' => $request->input('email')];
        return redirect()->route('usuarios.index')->with('mensagem', 'Usuário criado com sucesso!');
    }

    public function show($id)
    {
        if (isset($this->usuarios[$id])) {
            return "<h2>Detalhes do Usuário</h2>
                    <p><strong>ID:</strong> " . $id . "</p>
                    <p><strong>Nome:</strong> " . $this->usuarios[$id]['nome'] . "</p>
                    <p><strong>Email:</strong> " . $this->usuarios[$id]['email'] . "</p>
                    <p><a href='" . route('usuarios.edit', ['id' => $id]) . "'>Editar</a> |
                    <form method='POST' action='" . route('usuarios.destroy', ['id' => $id]) . "' style='display:inline'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button type='submit' onclick='return confirm(\"Tem certeza que deseja apagar?\")'>Apagar</button>
                    </form> |
                    <a href='" . route('usuarios.index') . "'>Voltar</a></p>";
        } else {
            return "Usuário não encontrado.";
        }
    }

    public function edit($id)
    {
        if (isset($this->usuarios[$id])) {
            return "<h2>Editar Usuário</h2>
                    <form method='POST' action='" . route('usuarios.update', ['id' => $id]) . "'>
                        <input type='hidden' name='_method' value='PUT'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        Nome: <input type='text' name='nome' value='" . $this->usuarios[$id]['nome'] . "'><br><br>
                        Email: <input type='email' name='email' value='" . $this->usuarios[$id]['email'] . "'><br><br>
                        <input type='submit' value='Atualizar'> |
                        <a href='" . route('usuarios.index') . "'>Voltar</a>
                    </form>";
        } else {
            return "Usuário não encontrado.";
        }
    }

    public function update(Request $request, $id)
    {
        if (isset($this->usuarios[$id])) {
            $this->usuarios[$id]['nome'] = $request->input('nome');
            $this->usuarios[$id]['email'] = $request->input('email');
            return redirect()->route('usuarios.show', ['id' => $id])->with('mensagem', 'Usuário atualizado com sucesso!');
        } else {
            return "Usuário não encontrado.";
        }
    }

    public function destroy($id)
    {
        if (isset($this->usuarios[$id])) {
            unset($this->usuarios[$id]);
            return redirect()->route('usuarios.index')->with('mensagem', 'Usuário apagado com sucesso!');
        } else {
            return "Usuário não encontrado.";
        }
    }
}