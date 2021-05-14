<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AtividadeUsuario extends Model
{
    use HasFactory;

    public function papel()
    {
        return $this->hasOne('App\Models\Papel');
    }

    public function dono()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function atividadeAcademica()
    {
        return $this->belongsTo('App\Models\AtividadeAcademica');
    }

    public function data_hora_adicionado()
    {
        $data_carbon = Carbon::parse($this->created_at, config('timezone'));
        return "Adicionado em " . $data_carbon->format("d/m/Y \a\s H\hi");
    }
}
