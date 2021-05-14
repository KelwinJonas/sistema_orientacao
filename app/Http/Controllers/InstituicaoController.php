<?php

namespace App\Http\Controllers;

use App\Models\Instituicao;
use App\Models\TemplateAtividade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InstituicaoController extends Controller
{


    public function listarInstituicoes()
    {
        return view('Instituicao.listar', ["instituicoes" => Instituicao::all()]);
    }

    public function verInstituicao($id)
    {
        $instituicao = Instituicao::find($id);
        if ($instituicao) {
            return view('Instituicao.ver', ["instituicao" => $instituicao]);
        }

        return redirect()->back();
    }

    public function salvarTemplate(Request $request)
    {
        $request->validate([
            "instituicao_id" => 'required',
            "tipo" => "required",
            "titulo" => "required",
        ]);

        $template = new TemplateAtividade;
        $template->fill($request->all());
        $template->save();
        return redirect()->back();
    }


    public function salvarEditarTemplate(Request $request)
    {
        $request->validate([
            "template_id" => 'required',
            "tipo" => "required",
            "titulo" => "required",
            "arr_template" => "required",
        ]);

        if ($template = TemplateAtividade::find($request->template_id)) {
            $template->fill($request->all());
            $template->arr_template = json_decode($request->arr_template);
            $template->save();
        }
        return redirect()->back();
    }


    public function cadastroInstituicao()
    {
        return view('Instituicao.cadastrar_instituicao');
    }

    public function salvarCadastrarInstituicao(Request $request)
    {
        $entrada = $request->all();

        $messages = [
            'required' => 'O campo nome é obrigatório.',
            'min' => 'O campo :attribute deve ter no mínimo :min caracteres.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
        ];

        $validator = Validator::make($entrada, Instituicao::$rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $instituicao = new Instituicao();
        $instituicao->nome = $entrada['nome'];
        $instituicao->save();

        return redirect()->route('instituicao.listar');
    }
}
