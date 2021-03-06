<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    use HasFactory;

    protected $fillable = ['telefone_primario', 'telefone_secundario'];

    public static $rules = ['telefone_primario' => 'required|digits:11',
                            'telefone_secundario' => 'nullable|digits:11',
    ];
}
