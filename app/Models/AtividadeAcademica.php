<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtividadeAcademica extends Model
{
    use HasFactory;

    protected $fillable = ['tipo', 'titulo', 'data_inicio', 'data_fim'];

    public static $rules = [
                            'tipo' => 'required|min:5|max:50',
                            'titulo' => 'required|min:5|max:50',
                            'data_inicio' => 'required|date',
                            'data_fim' => 'required|date'
    ];

    public function atividadeUsuario(){
        return $this->hasMany('App\Models\AtividadeUsuario');
    }

    public function secoes(){
        return $this->hasMany('App\Models\Secao');
    }
}
