<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instituicao extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        #perguntar se colocar mais algum campo em instituição
    ];

    public static $rules = [
        'nome' => 'required|min:3|max:255',
    ];

    public function templateAtividade(){
        return $this->hasMany('App\Models\TemplateAtividade');
    }

    public function usuarios(){
        return $this->hasMany('App\Models\Users');
    }
}
