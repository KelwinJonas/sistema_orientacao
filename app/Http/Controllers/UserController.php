<?php

namespace App\Http\Controllers;

use App\Models\AtividadeAcademica;
use App\Models\Instituicao;
use App\Models\Telefone;
use App\Models\TemplatePessoal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use stdClass;

class UserController extends Controller
{
    public function cadastroUsuario(){
        return view('User.cadastrar_usuario')->with('instituicoes', Instituicao::all());
    }

    public function redefinirSenha(){
        return view('esqueceu_senha');
    }

    public function salvarCadastrarUsuario(Request $request){
        $entrada = $request->all();

        $messages = [
            'name.required' => 'O campo nome é obrigatório.',
            'instituicao.required' => 'O campo instituição é obrigatório.',
            'password.required' => 'O campo senha é obrigatório.',
            'password.confirmed' => 'O campo confirmar senha é obrigatório.',
            'required' => 'O campo :attribute é obrigatório.',
            'email' => 'O campo email deve ser preenchido com um email válido.',
            'confirmed' => 'A confirmação da senha deve ser igual à senha digitada;',
            'digits' => 'O campo :attribute deve conter 11 digitos',
        ];

        $validatorUsuario = Validator::make($entrada, User::$rules, $messages);
        if($validatorUsuario->fails()){
            return redirect()->back()->withErrors($validatorUsuario)->withInput();
        }

        $validatorTelefone = Validator::make($entrada, Telefone::$rules, $messages);
        if($validatorTelefone->fails()){
            return redirect()->back()->withErrors($validatorTelefone)->withInput();
        }

        $usuario = new User();
        $usuario->name = $entrada['name'];
        $usuario->cpf = $entrada['cpf'];
        $usuario->email = $entrada['email'];
        $usuario->password = Hash::make($entrada['password']);
        if($entrada['instituicao'] === "outros"){
            $usuario->instituicao_id = null;
        }else{
            $instituicao = Instituicao::find($entrada['instituicao']);
            $usuario->instituicao_id = $instituicao->id;
        }
        $usuario->save();
        
        $telefone = new Telefone();
        $telefone->telefone_primario = $entrada['telefone_primario'];
        $telefone->telefone_secundario = $entrada['telefone_secundario'];
        $telefone->user_id = $usuario->id;
        $telefone->save();


        return redirect()->route('listarAtividades');
    }

    public function modelos_pessoais() {
        return view('User.templates_pessoais');
    }


    public function gerar_arvore($secao_raiz) {

        $secao = new stdClass;
        $secao->tipo = "secao";
        $secao->titulo = $secao_raiz->nome;
        $secao->filhos = [];

        foreach($secao_raiz->campos as $campo) {
            $campo_std = new stdClass;
            $campo_std->tipo = "campo";
            $campo_std->titulo = $campo->titulo;
            $campo_std->filhos = [];
            array_push($secao->filhos, $campo_std);
        }

        foreach($secao_raiz->secoes as $secao_filho) {
            array_push($secao->filhos, $this->gerar_arvore($secao_filho));
        }
        
        return $secao;

    }
    
    public function salvar_modelos_pessoais(Request $request) {
        $val = Validator::make($request->all(), [
            'titulo_template' => 'required',
            'tipo_template' => 'required',
            'atividade_id' => 'required|exists:atividade_academicas,id',
        ]);


        $atividade = AtividadeAcademica::find($request->atividade_id);
        $template = new TemplatePessoal;
        $template->tipo = $request->tipo_template;
        $template->titulo = $request->titulo_template;


        $template_arr = [];
        foreach($atividade->secoes as $secao) {
            $raiz = $this->gerar_arvore($secao);
            array_push($template_arr, $raiz);
        }

        $template->arr_template = json_encode($template_arr);
        $template->user_id = Auth::id();
        $template->save();
        return redirect()->route('templates.pessoais');
    }

    public function salvar_novo_modelo(Request $request) {
        $request->validate([
            "tipo" => "required",
            "titulo" => "required",
        ]);

        $template = new TemplatePessoal;
        $template->tipo = $request->tipo;
        $template->titulo = $request->titulo;
        $template->user_id = Auth::id();
        $template->save();
        return redirect()->back();
    }

    public function salvar_editar_modelo(Request $request) {
        $request->validate([
            "template_id" => 'required|exists:template_pessoals,id',
            "tipo" => "required",
            "titulo" => "required",
            "arr_template" => "required",
        ]);

        if ($template = TemplatePessoal::find($request->template_id)) {
            $template->tipo = $request->tipo;
            $template->titulo = $request->titulo;            
            $template->arr_template = json_decode($request->arr_template);
            $template->save();
        }

        return redirect()->back();
    }

    public function deletar_modelo_pessoais(Request $request) {
        $template = TemplatePessoal::find($request->template_id);
        if($template) {
            $template->delete();
        }
        return redirect()->back();        
    }
    
}
