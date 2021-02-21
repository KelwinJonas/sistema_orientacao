<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtividadeAcademica extends Model
{
    use HasFactory;

    public function atividadeUsuario(){
        return $this->hasMany('App\Models\AtividadeUsuario');
    }

    public function secoes(){
        return $this->hasMany('App\Models\Secao');
    }
}
