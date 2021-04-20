<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtividadeAcademica extends Model
{
    use HasFactory;

    protected $fillable = ['tipo', 'titulo', 'descricao', 'data_inicio', 'data_fim', 'cor_card', 'folder_id'];

    public static $rules = [
                            'tipo' => 'required|min:3|max:50',
                            'titulo' => 'required|min:5|max:50',
                            'descricao' => 'required|min:10|max:200',
                            'data_inicio' => 'required|date',
                            'data_fim' => 'required|date',
    ];

    public function atividadesUsuario(){
        return $this->hasMany('App\Models\AtividadeUsuario');
    }

    public function secoes(){
        return $this->hasMany('App\Models\Secao')->where('secao_id', NULL)->orderBy('ordem', 'asc');
    }

    public function dono(){
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
