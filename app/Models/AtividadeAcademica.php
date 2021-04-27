<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AtividadeAcademica extends Model
{
    use HasFactory;

    public const CORES = [
        "#2ecc71",
        "#3498db",
        "#f1c40f",
        "#e74c3c",
        "#836FFF",
        "#708090",
        "#808000",
        "#BC8F8F",
        "#FF1493",
        "#7CFC00", 
       
    ];

    protected $fillable = ['tipo', 'titulo', 'descricao', 'data_inicio', 'data_fim', 'cor_card', 'folder_id'];

    public static $rules = [
        'tipo' => 'required|min:3|max:50',
        'titulo' => 'required|min:5|max:50',
        'descricao' => 'required|min:10|max:200',
        'data_inicio' => 'required|date',
        'data_fim' => 'required|date',
    ];

    public function atividadesUsuario() {
        return $this->hasMany('App\Models\AtividadeUsuario');
    }

    public function secoes() {
        return $this->hasMany('App\Models\Secao')->where('secao_id', NULL)->orderBy('ordem', 'asc');
    }

    public function dono() {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function user_logado_pode_pessoas() {
        // Só o proprietario ou qualquer editor pode adicionar pessoas?
        foreach ($this->atividadesUsuario as $usuarios) {
            if ($usuarios->user_id == Auth::id()) {
                $papel = Papel::where('atividade_usuario_id', $usuarios->id)->first();
                if ($papel && ($papel->nome == Papel::PROPRIETARIO) || ($papel->nome == Papel::EDITOR)) {
                    return true;
                }
            }
        }
        return false;
    }

    public function permissao_user_logado() {
        foreach ($this->atividadesUsuario as $usuarios) {
            if ($usuarios->user_id == Auth::id()) {
                return Papel::where('atividade_usuario_id', $usuarios->id)->first()->nome;
            }
        }

        return NULL;
    }

    public function user_logado_editor_propietario() {
        return (($this->permissao_user_logado() == \App\Models\Papel::EDITOR) || ($this->permissao_user_logado() == \App\Models\Papel::PROPRIETARIO)); 
    }
}
