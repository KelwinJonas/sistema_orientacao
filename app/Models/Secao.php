<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Secao extends Model
{
    use HasFactory;

    public function secoes(){
        return $this->hasMany('App\Models\Secao');
    }

    public function campos(){
        return $this->hasMany('App\Models\Campo');
    }
}
