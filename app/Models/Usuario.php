<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'cpf', 'email' , 'senha'];

    public static $rules = [
                           'nome' => 'required|min:3|max:100',
                           'cpf' => 'required|min:14|max:14',
                           'email' => 'required|email',
                           'senha' => 'required|confirmed|min:8|max:64',
    ];

    public function instituicao(){
        return $this->hasOne('App\Models\Instituicao');
        //REVER - Um usuário possui uma instituição ou mais de uma? 
    }

    public function endereco(){
        return $this->hasOne('App\Models\Endereco');
    }

    public function telefone(){
        return $this->hasOne('App\Models\Telefone');
    }

    public function atividadeUsuario(){
        return $this->hasMany('App\Models\AtividadeUsuario');
    }

    public function anotacoes(){
        return $this->hasMany('App\Models\Anotacao');
    }
}
