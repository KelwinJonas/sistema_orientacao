<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use HasFactory;

    protected $fillable = ['rua', 'bairro','numero','cep','estado','cidade'];

    public static $rules = [   'rua' => array('regex:/^[\pL\s]+$/u'),
                               'bairro' => array('regex:/^[\pL\s]+$/u'),
                               'numero' => array('regex:/^(([0-9]+)\-([A-Z]|[a-z])|[0-9]+)/'),
                               'cep' => array('regex:/^\d{5}-\d{3}/'),
                               'estado' => array('regex:/^(AC|AL|AM|AP|BA|CE|DF|ES|GO|MA|MG|MS|MT|PA|PB|PE|PI|PR|RJ|RN|RO|RR|RS|SC|SE|SP|TO)/'),
                               'cidade' => array('regex:/^[\pL\s]+$/u'),
                            ];

    public static $messages = [ 
                                'rua.regex' => 'O nome da rua está inválido',
                                'bairro.alpha'=>'O nome do bairro está inválido',
                                'numero.regex' => 'O número está inválido',
                                'cep.regex' => "O CEP está inválido",
                                'estado.regex' => "O Estado está invalido (UF)",
                                'cidade.alpha' => "A cidade está inválida",
    ];
}
