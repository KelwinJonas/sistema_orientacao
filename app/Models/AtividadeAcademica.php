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

    public function atividadesUsuario()
    {
        return $this->hasMany('App\Models\AtividadeUsuario');
    }

    public function secoes()
    {
        return $this->hasMany('App\Models\Secao')->where('secao_id', NULL)->orderBy('ordem', 'asc');
    }

    public function dono()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function permissao_user_logado()
    {
        foreach ($this->atividadesUsuario as $usuarios) {
            if ($usuarios->user_id == Auth::id()) {
                return Papel::where('atividade_usuario_id', $usuarios->id)->first()->nome;
            }
        }

        return NULL;
    }

    public function user_logado_proprietario($papel = NULL)
    {
        $papel = ($papel != NULL ? $papel : $this->permissao_user_logado());
        return ($papel == Papel::PROPRIETARIO);
    }

    public function user_logado_gerente_ou_acima($papel = NULL)
    {
        $papel = ($papel != NULL ? $papel : $this->permissao_user_logado());
        return (($papel == Papel::GERENTE_DE_CONTEUDO) || $this->user_logado_proprietario($papel));
    }

    public function user_logado_editor_ou_acima($papel = NULL)
    {
        $papel = ($papel != NULL ? $papel : $this->permissao_user_logado());
        return (($papel == Papel::EDITOR) || $this->user_logado_gerente_ou_acima($papel));
    }

    public function user_logado_leitor_ou_acima($papel = NULL)
    {
        $papel = ($papel != NULL ? $papel : $this->permissao_user_logado());
        return (($papel == Papel::LEITOR) || $this->user_logado_editor_ou_acima($papel));
    }


    public function arquivos(){
        return $this->hasMany('App\Models\Arquivo');
    }

}
