<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AtividadeAcademicaController extends Controller
{
    public function cadastroAtividade(){
        return view('AtividadeAcademica.cadastrar_atividade_academica');
    }

    public function salvarCadastrarAtividade(Request $request){

    }
}
