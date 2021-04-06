<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtividadeUsuario extends Model
{
    use HasFactory;

    public function papel(){
        return $this->hasOne('App\Models\Papel');
    }

    public function atividadeAcademica(){
        return $this->belongsTo('App\Models\AtividadeAcademica');
    }
}
