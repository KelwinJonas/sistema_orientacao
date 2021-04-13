<?php

namespace App\Http\Controllers;

use App\Models\AtividadeAcademica;
use App\Models\AtividadeUsuario;
use App\Models\Papel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PessoaController extends Controller
{
    public function salvarAdicionarPessoa(Request $request, $atividade_id){
        //Fazer validação!!!
        $pessoaAdicionada = User::where('email', '=', $request->input('email'))->get()->first();
        if($pessoaAdicionada){
            $usuarioLogado = User::find(Auth::id());
            if($pessoaAdicionada->email != $usuarioLogado->email){
                $atividadeAcademica = AtividadeAcademica::find($atividade_id);
                if($atividadeAcademica){
                    $atividadeUsuario = new AtividadeUsuario();
                    $atividadeUsuario->user_id = $pessoaAdicionada->id;
                    $atividadeUsuario->atividade_academica_id = $atividadeAcademica->id;
                    $atividadeUsuario->save();

                    $papelPessoaAdicionada = new Papel();
                    $papelPessoaAdicionada->nome = $request->input('papel');
                    $papelPessoaAdicionada->atividade_usuario_id = $atividadeUsuario->id;
                    $papelPessoaAdicionada->save();
                }
            }
        }
        return redirect()->route('verAtividade.verPessoas', $atividadeAcademica->id);
    }
}
