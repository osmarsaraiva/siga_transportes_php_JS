<?php

namespace App\Http\Controllers;

use App\Models\funcionario;
use Illuminate\Http\Request;

class CadFuncionariosController extends Controller
{
    public function index()
    {
        $tabela = funcionario::orderby('id', 'desc')->paginate();
        return view('painel-admin.funcionarios.index', ['itens' => $tabela]);
    }

    public function create()
    {
        return view('painel-admin.funcionarios.create');
    }

    public function insert(Request $request)
    {
       
        $num = $request->salario;
        //settype($num, "float");
        $english_format_number = number_format(str_replace(",",".",str_replace(".","",$num)), 2, '.', '');
       
        $tabela = new funcionario();
        $tabela->nome = $request->nome;
        $tabela->fk_empresa_id = $request->fk_empresa_id;
        $tabela->CPF = $request->CPF;
        $tabela->PIS = $request->PIS;
        $tabela->data_admissao = $request->data_admissao;
        $tabela->email = $request->email;
        $tabela->endereco = $request->endereco;
        $tabela->fk_funcao_id = $request->fk_funcao_id;
        $tabela->telefone = $request->telefone;
        $tabela->salario = $english_format_number;
        $tabela->fk_cidades_id = $request->fk_cidades_id;
        $tabela->fk_situacoes_id = $request->fk_situacoes_id;
      

        $itens = funcionario::where('CPF', '=', $request->CPF)->count();

        if ($itens > 0) {
            echo "<script language='javascript'> window.alert('Funcionário já Cadastrado!') </script>";
            return view('painel-admin.funcionarios.create');
        } else {
            $tabela->save();
        }

        return redirect()->route('funcionarios.index');
    }

    public function edit(funcionario $item)
    {
        return view('painel-admin.funcionarios.edit', ['item' => $item]);
    }

    public function editar(Request $request, funcionario $item)
    {

        $num_edit = $request->salario;
        //settype($num, "float");
        $english_format_number = number_format(str_replace(",",".",str_replace(".","",$num_edit)), 2, '.', '');


        $item->nome = $request->nome;
        $item->fk_empresa_id = $request->fk_empresa_id;
        $item->CPF = $request->CPF;
        $item->PIS = $request->PIS;
        $item->data_admissao = $request->data_admissao;
        $item->email = $request->email;
        $item->endereco = $request->endereco;
        $item->fk_funcao_id = $request->fk_funcao_id;
        $item->telefone = $request->telefone;  
        $item->salario = $english_format_number;
        $item->fk_cidades_id = $request->fk_cidades_id;
        $item->fk_situacoes_id = $request->fk_situacoes_id;
       

        $oldcpf = $request->oldcpj;

        if ($oldcpf != $request->cpf) {

            $itens0 = funcionario::where('CPF', '=', $request->CPF)->count();

            if ($itens0 > 0) {
                echo "<script language='javascript'> window.alert('Funcionário já Cadastrado!') </script>";
                return view('painel-admin.funcionarios.edit', ['item' => $item]);
            }
        }

        $item->save();
        return redirect()->route('funcionarios.index');
    }

    public function delete(funcionario $item)
    {
        $item->delete();
        return redirect()->route('funcionarios.index');
    }

    public function modal($id)
    {
        $item = funcionario::orderby('id', 'desc')->paginate();
        return view('painel-admin.funcionarios.index', ['itens' => $item, 'id' => $id]);
    }
}
