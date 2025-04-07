<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $pedidos = []; // Simulação de banco de dados
    protected $nextPedidoId = 1;

    public function __construct()
    {
        // Inicializando alguns pedidos para demonstração
        $this->pedidos = [
            1 => ['itens' => ['Camiseta', 'Calça'], 'total' => 75.50],
            2 => ['itens' => ['Livro', 'Caneta'], 'total' => 32.00],
        ];
        $this->nextPedidoId = count($this->pedidos) + 1;
    }

    /**
     * Exibe a lista de todos os pedidos.
     *
     * @return string
     */
    public function index()
    {
        $output = "<h2>Lista de Pedidos</h2><ul>";
        if (!empty($this->pedidos)) {
            foreach ($this->pedidos as $id => $pedido) {
                $output .= "<li><a href='" . route('pedidos.show', ['id' => $id]) . "'>Pedido #" . $id . "</a></li>";
            }
        } else {
            $output .= "<li>Nenhum pedido cadastrado.</li>";
        }
        $output .= "</ul><p><a href='" . route('pedidos.create') . "'>Criar Novo Pedido</a></p>";
        return $output;
    }

    /**
     * Exibe o formulário para criar um novo pedido.
     *
     * @return string
     */
    public function create()
    {
        return "<h2>Criar Novo Pedido</h2><form method='POST' action='" . route('pedidos.store') . "'>
            <input type='hidden' name='_token' value='" . csrf_token() . "'>
            Itens (separados por vírgula): <input type='text' name='itens'><br><br>
            Total: <input type='number' name='total' step='0.01'><br><br>
            <input type='submit' value='Salvar'>
        </form>
        <p><a href='" . route('pedidos.index') . "'>Voltar para a lista de pedidos</a></p>";
    }

    /**
     * Salva um novo pedido.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $itens = $request->input('itens');
        $total = $request->input('total');

        if (!empty($itens) && is_numeric($total)) {
            $this->pedidos[$this->nextPedidoId++] = ['itens' => explode(',', $itens), 'total' => floatval($total)];
            return redirect()->route('pedidos.index')->with('mensagem', 'Pedido criado com sucesso!');
        } else {
            return back()->withErrors(['error' => 'Por favor, preencha os itens e o total corretamente.']);
        }
    }

    /**
     * Exibe os detalhes de um pedido específico.
     *
     * @param  int  $id
     * @return string
     */
    public function show($id)
    {
        if (isset($this->pedidos[$id])) {
            return "<h2>Detalhes do Pedido #" . $id . "</h2>
                    <p><strong>ID:</strong> " . $id . "</p>
                    <p><strong>Itens:</strong> " . implode(', ', $this->pedidos[$id]['itens']) . "</p>
                    <p><strong>Total:</strong> R$ " . number_format($this->pedidos[$id]['total'], 2, ',', '.') . "</p>
                    <p><a href='" . route('pedidos.edit', ['id' => $id]) . "'>Editar</a> |
                    <form method='POST' action='" . route('pedidos.destroy', ['id' => $id]) . "' style='display:inline'>
                        <input type='hidden' name='_method' value='DELETE'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        <button type='submit' onclick='return confirm(\"Tem certeza que deseja apagar o pedido #" . $id . "?\")'>Apagar</button>
                    </form> |
                    <a href='" . route('pedidos.index') . "'>Voltar para a lista de pedidos</a></p>";
        } else {
            return "Pedido #" . $id . " não encontrado.";
        }
    }

    /**
     * Exibe o formulário para editar um pedido específico.
     *
     * @param  int  $id
     * @return string
     */
    public function edit($id)
    {
        if (isset($this->pedidos[$id])) {
            return "<h2>Editar Pedido #" . $id . "</h2>
                    <form method='POST' action='" . route('pedidos.update', ['id' => $id]) . "'>
                        <input type='hidden' name='_method' value='PUT'>
                        <input type='hidden' name='_token' value='" . csrf_token() . "'>
                        Itens (separados por vírgula): <input type='text' name='itens' value='" . implode(', ', $this->pedidos[$id]['itens']) . "'><br><br>
                        Total: <input type='number' name='total' step='0.01' value='" . $this->pedidos[$id]['total'] . "'><br><br>
                        <input type='submit' value='Atualizar'> |
                        <a href='" . route('pedidos.show', ['id' => $id]) . "'>Voltar para os detalhes do pedido</a> |
                        <a href='" . route('pedidos.index') . "'>Voltar para a lista de pedidos</a>
                    </form>";
        } else {
            return "Pedido #" . $id . " não encontrado.";
        }
    }

    /**
     * Atualiza um pedido específico.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        if (isset($this->pedidos[$id])) {
            $itens = $request->input('itens');
            $total = $request->input('total');

            if (!empty($itens) && is_numeric($total)) {
                $this->pedidos[$id]['itens'] = explode(',', $itens);
                $this->pedidos[$id]['total'] = floatval($total);
                return redirect()->route('pedidos.show', ['id' => $id])->with('mensagem', 'Pedido #' . $id . ' atualizado com sucesso!');
            } else {
                return back()->withErrors(['error' => 'Por favor, preencha os itens e o total corretamente.']);
            }
        } else {
            return "Pedido #" . $id . " não encontrado.";
        }
    }

    /**
     * Remove um pedido específico.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        if (isset($this->pedidos[$id])) {
            unset($this->pedidos[$id]);
            return redirect()->route('pedidos.index')->with('mensagem', 'Pedido #' . $id . ' apagado com sucesso!');
        } else {
            return "Pedido #" . $id . " não encontrado.";
        }
    }
}