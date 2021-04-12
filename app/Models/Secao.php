<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secao extends Model
{
    use HasFactory;

    protected $fillable = [
        'tipo',
        'nome',
        'legenda',
        'ordem',
        'atividade_academica_id',
        'secao_id'
    ];

    public function secoes(){
        return $this->hasMany('App\Models\Secao');
    }

    public function campos(){
        return $this->hasMany('App\Models\Campo');
    }

    public function contem_subsecao_com_id($id_alvo) {
        $ret_val = false;

        foreach($this->secoes as $subsecao) {
            $ret_val |= ($subsecao->id == $id_alvo);
            $ret_val |= $subsecao->contem_subsecao_com_id($id_alvo);
        }

        return $ret_val;
    }

    public function arvore_secoes($secao) {
        $str_r ="";
        $str_r .= "<div class=\"col-md-12 link_secao" . (($this->id == $secao->id) ? " link_secao_ativa " : "") . "\" style=\"margin-top: 2.5px; margin-bottom:2.5px;\">";
        $str_r .= "<a href=" .  route('verAtividade.verSecoes', $this->atividade_academica_id) . "/" . $this->id . ">" . $this->nome . "</a>";

        if($this->contem_subsecao_com_id($secao->id) || $this->id == $secao->id) {
            if($this->id == $secao->id) {
                $str_r .= "<span class=\"float-right\">";
                $str_r .= "<a id=\"botao-add-subsecao\" data-toggle=\"modal\" data-target=\"#modal-criar-secao\" style=\"font-size: 15px; color: #212529 !important;\" onclick=\"add_id_na_subsecao(". $this->id .")\">Add. Subseção</a>";
                $str_r .= "<a id=\"botao-editar-secao\" data-toggle=\"modal\" data-target=\"#modal-editar-secao\" style=\"font-size: 15px; color: #212529 !important;\"  onclick=\"add_id_na_subsecao(null)\" >Editar</a>";
                $str_r .= "</span>";
            }
            $str_r .= "<br />";
            $str_r .= "<div>";
            foreach($this->secoes as $subsecao) {
                $str_r .= $subsecao->arvore_secoes($secao);
            }
            $str_r .= "</div>";
        }

        
        $str_r .= "</div>";
        return $str_r;
    }
    
}
