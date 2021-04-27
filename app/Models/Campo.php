<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campo extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'secao_id',
        'legenda',
    ];

    public function anotacoes(){
        return $this->hasMany('App\Models\Anotacao');
    }

    public function titulo_escapado() {
        return json_encode($this->titulo);
    }

    public function legenda_escapada() {
        return json_encode($this->legenda);
    }

    public function secao() {
        return $this->belongsTo('App\Models\Secao');
    }

}
