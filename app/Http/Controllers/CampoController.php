<?php

namespace App\Http\Controllers;

use App\Models\Anotacao;
use App\Models\Campo;
use App\Models\Secao;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampoController extends Controller
{

    public function salvarCampo(Request $request) {
        $request->validate([
            "secao_id" => "required|exists:secaos,id",
            "campo_id" => "nullable|exists:campos,id",
            "titulo" => "required|min:5",
        ]);

        $campo = new Campo;

        //EDIÇÂO
        if($request->campo_id != NULL) $campo = Campo::find($request->campo_id);

        $campo->fill($request->all());

        //TODO: criar o que seria o conteudo, mas ai depende do editor que for usa
        
        $campo->save();

        return redirect()->back();
    }


    public function deletarCampo(Request $request) {
        try {
            Campo::find($request->campo_id)->delete();
        }
        catch(Exception $ex) {}
        return redirect()->back();
    }


    public function anotacoes_html($id_campo) {
        $campo = Campo::find($id_campo);
        if($campo) return view('AtividadeAcademica.listagem_anotacoes', ["campo" => $campo]);
    }


    public function salvar_anotacao(Request $request) {

        $anotacao = new Anotacao;
        $anotacao->fill($request->all());
        $anotacao->user_id = Auth::id();
        $anotacao->status = 1;
        $anotacao->save();
        
        return "";
    }

    public function deletar_anotacao(Request $request) {
        try{
            //TODO: permissoes sobre a anotação
            $anotacao = Anotacao::find($request->anotacao_id);
            $anotacao->delete();
        }
        catch(Exception $ex) {}
    }
}
