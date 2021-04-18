<?php

namespace App\Http\Controllers;

use App\Models\AtividadeAcademica;
use App\Models\AtividadeUsuario;
use App\Models\Papel;
use App\Models\Secao;
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
        return view('AtividadeAcademica.listar_atividades_academicas')->with
        ([
            'atividadesUsuario' => $usuarioLogado->atividadesUsuario,
            'usuarioLogado' => $usuarioLogado,
        ]);
    }

    public function verAtividade($atividade_id){
        $atividade = AtividadeAcademica::find($atividade_id);
        if($atividade){
            return view('AtividadeAcademica.ver_atividade_academica', ['atividade' => $atividade]);
        }
    }

    public function verSecoes($atividade_id, $secao_atual = 0){

        $atividade = AtividadeAcademica::find($atividade_id);
        $secao = Secao::find($secao_atual);
        if((!$secao) && ($atividade->secoes->count() > 0)) {
            return redirect()->route("verAtividade.verSecoes", [$atividade_id, $atividade->secoes[0]]);
        }


        if($atividade){
            return view('AtividadeAcademica.secoes', [
                'atividade' => $atividade,
                'secao' => $secao,
            ]);
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
        ];

        $validator = Validator::make($entrada, AtividadeAcademica::$rules, $messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $usuarioLogado = User::find(Auth::id());

        $atividadeAcademica = new AtividadeAcademica();
        $atividadeAcademica->tipo = $entrada['tipo'];
        $atividadeAcademica->titulo = $entrada['titulo'];
        $atividadeAcademica->descricao = $entrada['descricao'];
        $atividadeAcademica->data_inicio = $entrada['data_inicio'];
        $atividadeAcademica->data_fim = $entrada['data_fim'];
        $atividadeAcademica->cor_card = "#F0D882";
        $atividadeAcademica->user_id = $usuarioLogado->id;
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

    public function salvarEditarAtividade(Request $request, $atividade_id){
        $entrada = $request->all();
        
        $atividadeAcademica = AtividadeAcademica::find($atividade_id);
        //dd($atividadeAcademica);
        //dd($entrada);
        $messages = [
            'required' => 'O campo :attribute é obrigatório.',
            'min' => 'O campo :attribute deve ter no mínimo :min caracteres.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
            'date' => 'O campo :attribute está inválido.',
        ];

        $validator = Validator::make($entrada, AtividadeAcademica::$rules, $messages);
        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $atividadeAcademica->update([
            'tipo' => $request->input('tipo'),
            'titulo' => $request->input('titulo'),
            'descricao' => $request->input('descricao'),
            'data_inicio' => $request->input('data_inicio'),
            'data_fim' => $request->input('data_fim'),
        ]);
        
        // dd($entrada['cor_card']);

        if($request->input('cor_card')){
            $atividadeAcademica->update([
                'cor_card' => $request->input('cor_card')
            ]);
        }

        return redirect()->route('listarAtividades');
    }
}
