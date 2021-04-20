<?php

namespace App\Http\Controllers;

use App\Models\Secao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SecaoController extends Controller
{

    private function ordenar_secoes($secoes) {
        for($i = 0; $i < $secoes->count(); $i++) {
            for($j = 0; $j < $secoes->count(); $j++) {
                if($i != $j && $secoes[$i]->ordem == $secoes[$j]->ordem) {
                    $mais_antigo = $secoes[$i];
                    $mais_novo = $secoes[$j];
                    if($mais_novo->updated_at < $mais_antigo->updated_at) {
                        $mais_antigo = $secoes[$j];
                        $mais_novo = $secoes[$i];
                    }

                    $mais_antigo->ordem++;
                    $mais_antigo->save();
                    return $this->ordenar_secoes($secoes);

                }
            }

            $this->ordenar_secoes($secoes[$i]->secoes);
        }
    }

    public function salvarAdicionarSecao(Request $request){
        $validator = Validator::make($request->all(), [
            'tipo' => 'required',
            'nome' => 'required',
            'legenda' => 'required',
            'atividade_academica_id' => 'required|exists:atividade_academicas,id',
            'secao_id' => 'nullable|exists:secaos,id'
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with(["localizacao_erro" => "criar"]);
        }

        $nova_secao = new Secao;
        $nova_secao->fill($request->all());
        $nova_secao->save();
        return redirect()->back();
    }

    public function salvarEditarSecao(Request $request){
        $validator = Validator::make($request->all(), [
            'tipo' => 'required',
            'nome' => 'required',
            'legenda' => 'required',
            'atividade_academica_id' => 'required|exists:atividade_academicas,id',
        ]);

        if($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with(["localizacao_erro" => "editar"]);
        }

        $nova_secao = Secao::find($request->secao_id);
        $nova_secao->fill($request->all());
        $nova_secao->save();
        return redirect()->back();
    }

    public function deletarSecao(Request $request) {
        $sec = Secao::find($request->secao_id);
        ($sec ? $sec->delete() : "");
        return redirect()->back();
    }


    public function salvar_ordenar_secao(Request $request) {
        $id_secao_arrastada = $request->id_secao_arrastada;
        $id_irmao_ante = $request->id_irmao_ante;
        $id_irmao_post = $request->id_irmao_post;

        if($id_secao_arrastada == $id_irmao_ante || $id_secao_arrastada == $id_irmao_post || $id_irmao_ante == $id_irmao_post) {
            return redirect()->back();
        }

        $secao_arrastada = Secao::find($id_secao_arrastada);

        if($id_secao_arrastada == 0 || !($secao_arrastada)) {
            return redirect()->back();
        }

        $irmao_ante = Secao::find($id_irmao_ante);
        $irmao_post = Secao::find($id_irmao_post);


        if($irmao_ante) {
            $id_secao_testada = $id_irmao_ante;
            $secao_atual = $irmao_ante;
            while ($secao_atual = $secao_atual->secao_pai()) {
                $id_secao_testada = $secao_atual->id;
                if($id_secao_testada == $id_secao_arrastada) {
                    return redirect()->back();
                }
            }
        }

        if($irmao_post) {
            $id_secao_testada = $id_irmao_post;
            $secao_atual = $irmao_post;
            while ($secao_atual = $secao_atual->secao_pai()) {
                $id_secao_testada = $secao_atual->id;
                if($id_secao_testada == $id_secao_arrastada) {
                    return redirect()->back();
                }
            }
        }


        if($irmao_ante && $irmao_post) {
            $id_secao_pai = $irmao_ante->secao_id;
            $secao_arrastada->secao_id = $id_secao_pai;
            $secao_arrastada->ordem = ($irmao_post->ordem + $irmao_ante->ordem) / 2.0;
            $secao_arrastada->save();
            return redirect()->back();
        }

        if($irmao_ante && !$irmao_post) {
            $id_secao_pai = $irmao_ante->secao_id;
            $secao_arrastada->secao_id = $id_secao_pai;
            $secao_arrastada->ordem = $irmao_ante->ordem + 2.0; // Pra que as divições sejam sempre números pares, facilita pro servidor
            $secao_arrastada->save();
            return redirect()->back();
        }

        if(!$irmao_ante && $irmao_post) {
            $id_secao_pai = $irmao_post->secao_id;
            $secao_arrastada->secao_id = $id_secao_pai;
            $secao_arrastada->ordem = $irmao_post->ordem - 2.0; // Pra que as divições sejam sempre números pares, facilita pro servidor
            $secao_arrastada->save();
            return redirect()->back();
        }
    }

    public function salvar_subsecionar_secao(Request $request) {
        $id_secao_alvo = $request->id_secao_alvo;
        $id_secao_movida = $request->id_secao_arrastada_que_vai_entrar;


        $secao_alvo = Secao::find($id_secao_alvo);
        $secao_movida = Secao::find($id_secao_movida);

        if(!$secao_alvo || !$secao_movida) {
            return redirect()->back();
        }



        if(!($secao_alvo->secao_id == $secao_movida->secao_id)) {

            $secao_atual = $secao_alvo;
            do {
                if($secao_atual->id == $secao_movida->id) {
                    return redirect()->back();
                }

                $secao_atual = $secao_atual->secao_pai();
            } while($secao_atual);
        }

        $secao_movida->secao_id = $secao_alvo->id;

        if($secao_alvo->secoes->count() > 0) {
            $secao_movida->ordem = $secao_alvo->secoes->last()->ordem + 2.0;
        } else {
            $secao_movida->ordem = 10000.0;
        }
        $secao_movida->save();
        return redirect()->back();

    }

}
