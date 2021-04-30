<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Anotacao extends Model
{
    use HasFactory;

    protected $fillable = [
        'campo_id',
        'comentario',
    ];

    public function anotacoes()
    {
        return $this->hasMany('App\Models\Anotacao');
    }

    public function autor()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function campo()
    {
        return $this->belongsTo('App\Models\Campo', 'campo_id');
    }
}
