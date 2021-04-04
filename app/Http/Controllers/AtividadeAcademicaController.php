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

    public function listarAtividades(){
        //ENVIAR APENAS AS ATIVIDADES ASSOCIADAS AO USUARIO LOGADO
        return view('AtividadeAcademica.listar_atividades_academicas')->with('atividades', AtividadeAcademica::all());
    }

    public function verAtividade($atividade_id){
        $atividade = AtividadeAcademica::find($atividade_id);
        if($atividade){
            return view('AtividadeAcademica.ver_atividade_academica', ['atividade' => $atividade]);
        }
        //Coloca msg de erro caso a reunião não exista
    }

    public function salvarCadastrarAtividade(Request $request){
        $entrada = $request->all();
        
        $messages = [
            'required' => 'O campo :attribute é obrigatório.',
            'min' => 'O campo :attribute deve ter no mínimo :min caracteres.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
            'date' => 'O campo :attribute está inválido.',
            'cor_card.required' => 'O campo cor é obrigatório.',
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
        $atividadeAcademica->cor_card = $entrada['cor_card'];
        $atividadeAcademica->save();

        //ASSOCIAR AO USUARIO QUE ESTA LOGADO NO SISTEMA

        return redirect()->route('listarAtividades');
    }
}
