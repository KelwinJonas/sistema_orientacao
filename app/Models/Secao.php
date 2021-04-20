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
        'atividade_academica_id',
    ];


    public function secao_pai() {
        return Secao::find($this->secao_id);
    }
    
    public function secoes(){
        return $this->hasMany('App\Models\Secao')->orderBy('ordem', 'asc');
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
        $str_r .= "<hr class='hr_div_secoes'><div id_secao=\"". $this->id ."\" class=\"col-md-12 link_secao" . (($this->id == $secao->id) ? " link_secao_ativa " : "") . "\" style=\"margin-top: 2.5px; margin-bottom:2.5px;\">";
        $str_r .= "<a id_secao=\"". $this->id ."\" class='link_secao_arrastavel' href=" .  route('verAtividade.verSecoes', $this->atividade_academica_id) . "/" . $this->id . ">" . $this->nome . "</a>";

        if($this->contem_subsecao_com_id($secao->id) || $this->id == $secao->id) {
            $str_r .= "<br />";
            $str_r .= "<div>";
            foreach($this->secoes as $subsecao) {
                $str_r .= $subsecao->arvore_secoes($secao);
            }
            $str_r .= "</div>";
        }

        $str_r .= "</div><hr class='hr_div_secoes'>";
        return $str_r;
    }
    
}
