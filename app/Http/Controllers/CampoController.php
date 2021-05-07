<?php

namespace App\Http\Controllers;

use App\Models\Anotacao;
use App\Models\AtividadeAcademica;
use App\Models\Campo;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

class CampoController extends Controller
{

    public function salvarCampo(Request $request)
    {

        $validator = Validator::make($request->all(), [
            "secao_id" => "required|exists:secaos,id",
            "campo_id" => "nullable|exists:campos,id",
            "titulo" => "required|min:5",
            "legenda" => "required|min:5",
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with([
                "localizacao_erro" => "salvar_campo",
                "titulo_old" => $request->titulo,
                "legenda_old" => $request->legenda,
            ]);
        }


        $secao = AtividadeAcademica::find($request->secao_id);
        if (!$secao->atividade->user_logado_gerente_ou_acima()) {
            return redirect()->back(); //Só gerente ou proprietario pode
        }

        $campo = new Campo;
        if ($request->campo_id != NULL) $campo = Campo::find($request->campo_id); //EDIÇÂO
        $campo->fill($request->all());
        $campo->save();
        return redirect()->back();
    }


    public function deletarCampo(Request $request)
    {
        try {
            $campo = Campo::find($request->campo_id);
            if (!$campo->secao->atividade->user_logado_gerente_ou_acima()) {
                return redirect()->back();
            }
            $campo->delete();
        } catch (Exception $ex) {
        }
        return redirect()->back();
    }


    public function anotacoes_html($id_campo)
    {
        $campo = Campo::find($id_campo);
        if (!$campo || !$campo->secao->atividade->user_logado_leitor_ou_acima()) {
            return abort(403);
        }
        if ($campo) return view('AtividadeAcademica.secao.listagem_anotacoes', ["campo" => $campo]);
    }


    public function salvar_anotacao(Request $request)
    {
        try{
        if (Campo::find($request->campo_id)->secao->atividade->user_logado_leitor_ou_acima()) {
            $anotacao = new Anotacao;
            $anotacao->fill($request->all());
            $anotacao->user_id = Auth::id();
            $anotacao->status = 1;
            $anotacao->save();
        }} catch(Exception $ex) {}
    }

    public function deletar_anotacao(Request $request)
    {
        try {
            $anotacao = Anotacao::find($request->anotacao_id);
            if ($anotacao->campo->secao->atividade->user_logado_proprietario() || $anotacao->user_id == Auth::id()) {
                $anotacao->delete();
            }
        } catch (Exception $ex) {
        }
    }


    public function salvar_conteudo(Request $request)
    {
        $campo = Campo::find($request->id_campo);
        if ($campo && $campo->secao->atividade->user_logado_editor_ou_acima()) {
            $campo->conteudo = $request->conteudo;
            $campo->save();
        }
        return redirect()->back();
    }
}
