<?php

namespace App\Http\Controllers;

use App\Models\AtividadeAcademica;
use Illuminate\Http\Request;

class AtividadeAcademicaController extends Controller
{
    public function cadastroAtividade(){
        return view('AtividadeAcademica.cadastrar_atividade_academica');
    }

    public function salvarCadastrarAtividade(Request $request){
        $entrada = $request->all();
        
        $atividadeAcademica = new AtividadeAcademica();
        $atividadeAcademica->tipo = $entrada['tipo'];
        $atividadeAcademica->titulo = $entrada['titulo'];
        $atividadeAcademica->data_inicio = $entrada['data_inicio'];
        $atividadeAcademica->data_fim = $entrada['data_fim'];
        $atividadeAcademica->save();

        return "Atividade cadastrada com sucesso.";
    }
}
