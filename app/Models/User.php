<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'cpf',
        'email',
        'password',
        'refresh_token',
        'token', 
        'expires_in',
    ];

    public static $rules = [
        'name' => 'required|min:3|max:100',
        'cpf' => 'required|cpf',
        'email' => 'required|email',
        'password' => 'required|confirmed|min:8|max:64',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
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
