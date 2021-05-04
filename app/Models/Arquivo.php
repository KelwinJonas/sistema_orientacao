<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Arquivo extends Model
{
    use HasFactory;

    protected $fillable = ['nome', 'file_id', 'parent_id', 'marcador', 'palavra_chave', 'anotacoes', 'atividade_academica_id'];

    public static $rules = [
        'marcador' => 'nullable|min:3',
        'palavra_chave' => 'nullable|min:3',
        'anotacoes' => 'nullable|min:3'
    ];

    public function user(){
        return $this->belongsTo('App\Models\User');   
    }
}
