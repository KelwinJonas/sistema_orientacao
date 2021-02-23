<?php

namespace App\Http\Controllers;

use App\Models\Instituicao;
use Illuminate\Http\Request;

class InstituicaoController extends Controller
{
    public function cadastroInstituicao(){
        return view('Instituicao.cadastrar_instituicao');
    }

    public function salvarCadastrarInstituicao(Request $request){
        $entrada = $request->all();

        $instituicao = new Instituicao;
        $instituicao->nome = $entrada['nome'];
        $instituicao->save();

        return "Instituição cadastrada com sucesso.";
    }
}
