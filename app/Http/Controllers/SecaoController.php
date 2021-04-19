<?php

namespace App\Http\Controllers;

use App\Models\AtividadeAcademica;
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

}
