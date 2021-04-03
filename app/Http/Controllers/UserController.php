<?php

namespace App\Http\Controllers;

use App\Models\Instituicao;
use App\Models\Telefone;
use App\Models\User;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Validator;

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

        return "Usuário cadastrado com sucesso";
    }
}
