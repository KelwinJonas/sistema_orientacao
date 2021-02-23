<?php

namespace App\Http\Controllers;

use App\Models\Instituicao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InstituicaoController extends Controller
{
    public function cadastroInstituicao(){
        return view('Instituicao.cadastrar_instituicao');
    }

    public function salvarCadastrarInstituicao(Request $request){
        $entrada = $request->all();

        $messages = [
            'required' => 'O campo nome é obrigatório.',
            'min' => 'O campo :attribute deve ter no mínimo :min caracteres.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
        ];

        $validator = Validator::make($entrada, Instituicao::$rules, $messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $instituicao = new Instituicao;
        $instituicao->nome = $entrada['nome'];
        $instituicao->save();

        return "Instituição cadastrada com sucesso.";
    }
}
