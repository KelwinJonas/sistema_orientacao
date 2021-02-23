<?php

namespace App\Http\Controllers;

use App\Models\Endereco;
use App\Models\Instituicao;
use App\Models\Telefone;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    public function cadastroUsuario(){
        return view('Usuario.cadastrar_usuario')->with('instituicoes', Instituicao::all());
    }

    public function salvarCadastrarUsuario(Request $request){
        $entrada = $request->all();

        $messages = [
            'required' => 'O campo :attribute é obrigatório.',
            'min' => 'O campo :attribute deve ter no mínimo :min caracteres.',
            'max' => 'O campo :attribute deve ter no máximo :max caracteres.',
            'email' => 'O campo email deve ser preenchido com um email válido.',
            'confirmed' => 'A confirmação da senha deve ser igual à senha digitada',
            'digits' => 'O campo :attribute deve conter 11 digitos',
        ];

        $validatorUsuario = Validator::make($entrada, Usuario::$rules, $messages);
        if($validatorUsuario->fails()){
            return redirect()->back()->withErrors($validatorUsuario)->withInput();
        }

        $validatorTelefone = Validator::make($entrada, Telefone::$rules, $messages);
        if($validatorTelefone->fails()){
            return redirect()->back()->withErrors($validatorTelefone)->withInput();
        }

        $validatorEndereco = Validator::make($entrada, Endereco::$rules, $messages);
        if($validatorEndereco->fails()){
            return redirect()->back()->withErrors($validatorEndereco)->withInput();
        }

        $instituicao = Instituicao::find($entrada['instituicao']);
        $usuario = new Usuario();
        $usuario->nome = $entrada['nome'];
        $usuario->cpf = $entrada['cpf'];
        $usuario->email = $entrada['email'];
        $usuario->senha = Hash::make($entrada['senha']);
        $usuario->instituicao_id = $instituicao->id;
        $usuario->save();
        
        $telefone = new Telefone();
        $telefone->telefone_primario = $entrada['telefone_primario'];
        $telefone->telefone_secundario = $entrada['telefone_secundario'];
        $telefone->usuario_id = $usuario->id;
        $telefone->save();

        $endereco = new Endereco();
        $endereco->rua = $entrada['rua'];
        $endereco->bairro = $entrada['bairro'];
        $endereco->numero = $entrada['numero'];
        $endereco->cep = $entrada['cep'];
        $endereco->estado = $entrada['estado'];
        $endereco->cidade = $entrada['cidade'];
        $endereco->usuario_id = $usuario->id;
        $endereco->save();

        return "Usuário cadastrado com sucesso";
    }
}
