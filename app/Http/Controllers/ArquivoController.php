<?php

namespace App\Http\Controllers;

use App\Models\Arquivo;
use App\Models\AtividadeAcademica;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class ArquivoController extends DriveController
{
    public function salvarEditarArquivo(Request $request){
        $entrada = $request->all();

        $messages = [
            'O campo :attribute deve contér no mínimo :min caracteres'
        ];

        $validator = Validator::make($entrada, Arquivo::$rules, $messages);

        $arquivo = Arquivo::find($entrada['arquivo_id']);

        if($arquivo){
            $arquivo->update([
                'marcador' => $request->input('marcador'),
                'palavra_chave' => $request->input('palavra_chave'),
                'anotacoes' => $request->input('anotacoes'),
            ]
            );
        }

        $atividade = AtividadeAcademica::find($entrada['atividade_academica_id']);
        if($atividade){
            return redirect()->route('verAtividade.verArquivos', ['atividade_id' => $atividade->id]);
        }
    }
}
