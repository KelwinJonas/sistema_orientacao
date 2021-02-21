<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TemplateAtividade extends Model
{
    use HasFactory;

    public function secoes(){
        return $this->hasMany('App\Models\Secao');
    }
}
