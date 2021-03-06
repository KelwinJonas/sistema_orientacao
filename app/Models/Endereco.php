<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $fillable = ['rua', 'bairro','numero','cep','estado','cidade'];

    public static $rules = [   'rua' => 'nullable|min:8',
                               'bairro' => 'nullable|min:5',
                               'numero' => 'nullable|numeric',
                               'cep' => 'nullable|digits:8',
                               'estado' => 'nullable|', array('regex:/^(AC|AL|AM|AP|BA|CE|DF|ES|GO|MA|MG|MS|MT|PA|PB|PE|PI|PR|RJ|RN|RO|RR|RS|SC|SE|SP|TO)/'),
                               'cidade' => 'nullable|min:3',
                            ];

    public static $messages = [ 
                                'rua.min' => 'O nome da rua está inválido',
                                'bairro.min'=>'O nome do bairro está inválido',
                                'numero.numeric' => 'O número está inválido',
                                'cep.digits' => "O CEP está inválido",
                                'estado.regex' => "O Estado está invalido (UF)",
                                'cidade.min' => "A cidade está inválida",
    ];
}
