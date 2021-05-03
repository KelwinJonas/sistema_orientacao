<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'file_id', 'parent_id', 'marcador', 'palavra_chave', 'anotacoes', 'atividade_academica_id'];

    public function user(){
        return $this->belongsTo('App\Models\User');   
    }
}
