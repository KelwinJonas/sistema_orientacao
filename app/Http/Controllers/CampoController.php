<?php

namespace App\Http\Controllers;

use App\Models\Campo;
use App\Models\Secao;
use Exception;
use Illuminate\Http\Request;

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

}
