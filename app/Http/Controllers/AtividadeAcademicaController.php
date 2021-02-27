<?php

namespace App\Http\Controllers;

use App\Models\AtividadeAcademica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AtividadeAcademicaController extends Controller
{
    public function cadastroAtividade(){
        return view('AtividadeAcademica.cadastrar_atividade_academica');
    }

    public function salvarCadastrarAtividade(Request $request){
        $entrada = $request->all();
        
        $messages = [
            'required' => 'O campo :attribute é obrigatório.',
            'min' => 'O campo :attribute deve ter no mínimo :min caracteres.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
            'date' => 'O campo :attribute está inválido'
        ];

        $validator = Validator::make($entrada, AtividadeAcademica::$rules, $messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $atividadeAcademica = new AtividadeAcademica();
        $atividadeAcademica->tipo = $entrada['tipo'];
        $atividadeAcademica->titulo = $entrada['titulo'];
        $atividadeAcademica->data_inicio = $entrada['data_inicio'];
        $atividadeAcademica->data_fim = $entrada['data_fim'];
        $atividadeAcademica->save();

        return "Atividade cadastrada com sucesso.";
    }
}
