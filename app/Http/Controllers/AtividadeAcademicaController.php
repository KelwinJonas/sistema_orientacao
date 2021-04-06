<?php

namespace App\Http\Controllers;

use App\Models\AtividadeAcademica;
use App\Models\AtividadeUsuario;
use App\Models\Papel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AtividadeAcademicaController extends Controller
{
    public function cadastroAtividade(){
        return view('AtividadeAcademica.cadastrar_atividade_academica');
    }

    public function listarAtividades(){
        //ENVIAR APENAS AS ATIVIDADES ASSOCIADAS AO USUARIO LOGADO
        $usuarioLogado = User::find(Auth::id());
        return view('AtividadeAcademica.listar_atividades_academicas')->with('atividadesUsuario', $usuarioLogado->atividadesUsuario);
    }

    public function verAtividade($atividade_id){
        $atividade = AtividadeAcademica::find($atividade_id);
        if($atividade){
            return view('AtividadeAcademica.ver_atividade_academica', ['atividade' => $atividade]);
        }
    }

    public function verSecoes($atividade_id){
        $atividade = AtividadeAcademica::find($atividade_id);
        if($atividade){
            return view('AtividadeAcademica.secoes', ['atividade' => $atividade]);
        }
    }

    public function verArquivos($atividade_id){
        $atividade = AtividadeAcademica::find($atividade_id);
        if($atividade){
            return view('AtividadeAcademica.arquivos', ['atividade' => $atividade]);
        }
    }

    public function verPessoas($atividade_id){
        $atividade = AtividadeAcademica::find($atividade_id);
        if($atividade){
            return view('AtividadeAcademica.pessoas', ['atividade' => $atividade]);
        }
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

        $usuarioLogado = User::find(Auth::id());
        $atividadeUsuario = new AtividadeUsuario();
        $atividadeUsuario->user_id = $usuarioLogado->id;
        $atividadeUsuario->atividade_academica_id = $atividadeAcademica->id;
        $atividadeUsuario->save();

        $papel = new Papel();
        $papel->nome = "proprietario";
        $papel->atividade_usuario_id = $atividadeUsuario->id;
        $papel->save();

        return redirect()->route('listarAtividades');
    }
}
